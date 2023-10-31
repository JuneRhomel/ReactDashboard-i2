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
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }

  const token = `${user?.token}:tenant`;
  const soaParams: ParamGetSoaType = {
    accountcode: accountCode,
    userId: user?.tenantId as number,
  }
  const soaDetailsParams: ParamGetSoaDetailsType = {
    accountcode: accountCode,
    limit: 20,
  }
  const getSoaPromise = api.soa.getSoa(soaParams, token);  // get all soas
  const getSoaDetailsPromise = api.soa.getSoaDetails(soaDetailsParams, token);
  const [soaResponse, soaDetailsResponse] = await Promise.all([getSoaPromise, getSoaDetailsPromise]);
  const soas = soaResponse.success ? mapObject(soaResponse.data as SoaType[]) as SoaType[] : undefined;
  const allSoaDetails = soaDetailsResponse.success ? mapObject(soaDetailsResponse.data as SoaDetailsType[]) as SoaDetailsType[] : undefined;
  const soaIds = soas?.map((soa) => soa.id)
  const userSoaDetails = allSoaDetails?.filter((soaDetail) => soaIds?.includes(soaDetail.soaId));
  const filteredSoaDetails = userSoaDetails?.filter((detail: SoaDetailsType) => {
    return !(detail.particular.includes("SOA Payment") && detail.status === "Successful") && !detail.particular.includes("Balance");
  });

  const firstTwoDetailsMap = filteredSoaDetails?.reduce((result, detail) => {
    if (!result[detail.soaId]) {
      result[detail.soaId] = [];
    }

    if (result[detail.soaId].length < 2) {
      result[detail.soaId].push(detail);
    }

    return result;
  }, {} as {[key: string]: SoaDetailsType[]});

  const soaDetails =  firstTwoDetailsMap ? Object.values(firstTwoDetailsMap).flat() : undefined;
  soaDetails?.sort((a, b) => parseInt(b.id) - parseInt(a.id));
  const currentSoa = soas?.shift();
  const paidSoas = soas?.filter((soa: SoaType) => 
    soa.status === "Paid" && soa.id != currentSoa?.id
    );
  const unpaidSoas = soas?.filter((soa: SoaType) =>
    (soa.status === "Unpaid" || soa.status === "Partially Paid") && soa.id != currentSoa?.id
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
