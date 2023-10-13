import Layout from "@/components/layouts/layout";
import Section from "@/components/general/section/Section";
import { ParamGetServiceRequestsType, UserType } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";

export async function getServerSideProps(context: any){
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt: string = context?.req?.cookies?.token;
  const user = authorizeUser(jwt);
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }
  const token = `${user.token}:tenant`

  const getServiceRequestsProps: ParamGetServiceRequestsType = {
    accountcode: accountCode,
    userId: user.tenantId,
  }
  const response = await api.requests.getServiceRequests(getServiceRequestsProps, token)
  console.log(await response.json())
  return {
    props: {}
  }
}

export default function myrequest() {
  const props = {
    title: "Requests",
    headerAction: null,
  }
  
  return (
    <Layout title='i2 - Requests'>
      <Section props={props}/>
    </Layout>
  )
}
