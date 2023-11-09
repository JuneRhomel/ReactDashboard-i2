import Layout from "@/components/layouts/layout";
import { SoaPaymentsType, SoaType,  } from "@/types/models";
import { ParamGetSoaType, ParamGetSoaDetailsType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import Section from "@/components/general/section/Section";
import api from "@/utils/api";
import Dashboard from "@/components/pages/dashboard/Dashboard";
import encryptData from "@/utils/encryptData";

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
  const currentSoa = soas?.shift() as SoaType;
  currentSoa.encId = encryptData(currentSoa.id); // This needs to be moved to the api call somehow.
  const soaDetailsParams: ParamGetSoaDetailsType = {
    accountcode: accountCode,
    soaId: parseInt(currentSoa.id),
  }
  const getSoaPaymentsResponse = await api.soa.getSoaPayments(soaDetailsParams, token);  // get soa details (transactions for this soa)
  const soaDetails = getSoaPaymentsResponse.success ? getSoaPaymentsResponse.data as SoaPaymentsType[] : null;
  return {props: {authorizedUser: user, currentSoa, soaDetails}};
}

export default Dashboard
