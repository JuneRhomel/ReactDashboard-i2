import Layout from "@/components/layouts/layout";
import { SoaDetailsType, SoaType,  } from "@/types/models";
import { ParamGetSoaType, ParamGetSoaDetailsType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import Section from "@/components/general/section/Section";
import api from "@/utils/api";
import mapObject from "@/utils/mapObject";
import Dashboard from "@/components/pages/dashboard/Dashboard";

export async function getServerSideProps(context: any) {
  // Do the stuff to check if user is authenticated
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
    limit: 1,
  }
  const getSoaResponse = await api.soa.getSoa(soaParams, token);
  const soas = getSoaResponse.success ? getSoaResponse.data as SoaType[]: undefined;
  const soa = mapObject(soas?.shift() as SoaType) as SoaType;
  
  const soaDetailsParams: ParamGetSoaDetailsType = {
    accountcode: accountCode,
    soaId: parseInt(soa.id),
  }
  const getSoaDetailsResponse = await api.soa.getSoaDetails(soaDetailsParams, token);  // get soa details (transactions for this soa)
  const soaDetails = getSoaDetailsResponse.success ? mapObject(getSoaDetailsResponse.data as SoaDetailsType[]) as SoaDetailsType[] : undefined;
  return {props: {user, soa, soaDetails}};
}

export default Dashboard
