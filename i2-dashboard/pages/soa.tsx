import Soa from "@/components/pages/soa/Soa";
import { ParamGetSoaDetailsType, ParamGetSoaType, SoaType } from "@/types/models";
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";
import mapObject from "@/utils/mapObject";

export async function getServerSideProps(context: any) {
  //Fetch all the soa objects.
  let response;
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt = context.req.cookies.token;
  const user = authorizeUser(jwt);
  const token = `${user?.token}:tenant`;
  const soaParams: ParamGetSoaType = {
    accountcode: accountCode,
    userId: user?.tenantId as number,
  }

  response = await api.soa.getSoa(soaParams, token);
  const soas = mapObject(await response?.json());
  const currentSoa = soas.shift();
  const paidSoas = soas.filter((soa: SoaType) => 
    soa.status === "Paid" && soa.id != currentSoa.id
    );
  const unpaidSoas = soas.filter((soa: SoaType) =>
    (soa.status === "Unpaid" || soa.status === "Partially Paid") && soa.id != currentSoa.id
    );
  
  const soaDetailsParams: ParamGetSoaDetailsType = {
    accountcode: accountCode,
    soaId: currentSoa.id,
  }
  response = await api.soa.getSoaDetails(soaDetailsParams, token);
  const soaDetails = mapObject(await response?.json());

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
