import Soa from "@/components/pages/soa/Soa";
import { SoaDetailsType, SoaType } from "@/types/models";
import { ParamGetSoaDetailsType, ParamGetSoaType } from "@/types/apiRequestParams";
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";
import mapObject from "@/utils/mapObject";

export async function getServerSideProps(context: any) {
  // Need to update this function to address cases where the user is not authenticated therefor authorizeUser(jwt) returns null
  //Fetch all the soa objects.
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt = context.req.cookies.token;
  const user = authorizeUser(jwt);

  const token = `${user?.token}:tenant`;
  const soaParams: ParamGetSoaType = {
    accountcode: accountCode,
    userId: user?.tenantId as number,
  }
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }
  const response = await api.soa.getSoa(soaParams, token);  // get all soas
  const soas = mapObject(await response?.json());
  
  const soaDetails: SoaDetailsType[] = [];
  await Promise.all(soas.map(async (element: SoaType) => {
    const soaDetailsParams: ParamGetSoaDetailsType = {
      accountcode: accountCode,
      soaId: parseInt(element.id),
    }
    const response = await api.soa.getSoaDetails(soaDetailsParams, token);  // get soa details (transactions for this soa)
    const jsonResponse = await response.json();
    const thisSoaDetails: SoaDetailsType[] = jsonResponse && mapObject(jsonResponse) as SoaDetailsType[];
    if (thisSoaDetails) { 
      const filtered = thisSoaDetails.filter(detail => {
        return !(detail.particular.includes("SOA Payment") && detail.status === "Successful") && !detail.particular.includes("Balance");
      })
      filtered.splice(2);
      soaDetails.push(...filtered)
    };
  }));
  
  const currentSoa = soas.shift();
  const paidSoas = soas.filter((soa: SoaType) => 
    soa.status === "Paid" && soa.id != currentSoa.id
    );
  const unpaidSoas = soas.filter((soa: SoaType) =>
    (soa.status === "Unpaid" || soa.status === "Partially Paid") && soa.id != currentSoa.id
    );

    return {
    props: {
      currentSoa,
      paidSoas,
      unpaidSoas,
      soaDetails,
    }
  }
}

export default Soa
