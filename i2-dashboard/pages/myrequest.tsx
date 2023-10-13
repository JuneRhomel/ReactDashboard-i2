import Layout from "@/components/layouts/layout";
import Section from "@/components/general/section/Section";
import { ParamGetServiceRequestDetailsType, ParamGetServiceRequestType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import mapObject from "@/utils/mapObject";
import { json } from "stream/consumers";

export async function getServerSideProps(context: any){
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt: string = context?.req?.cookies?.token;
  const user = authorizeUser(jwt);
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }
  const token = `${user.token}:tenant`

  const getServiceRequestProps: ParamGetServiceRequestType = {
    accountcode: accountCode,
    userId: user.tenantId,
  }
  //get all issues, and work permits | filter this by the service request id for each service request
  //sort everything by id
  //get gatepass personel | filter this by the id of each service request
  let response = await api.requests.getServiceRequests(getServiceRequestProps, token);
  let jsonResponse = await response.json();
  const serviceRequests = jsonResponse && mapObject(jsonResponse);
  serviceRequests.sort((a: any, b: any) => a.id - b.id);
  
  response = await api.requests.getServiceRequestDetails(getServiceRequestProps, 'gatepass', token);
  jsonResponse = await response.json();
  const gatePasses = jsonResponse && mapObject(jsonResponse);
  
  response = await api.requests.getServiceRequestDetails(getServiceRequestProps, 'personnel', token);
  jsonResponse = await response.json();
  serviceRequests.map((request: any) => {
    if (request.type === "Gate Pass") {
      const permits = gatePasses.filter((gatePass: any) => gatePass.id == request.id)
      request.data = permits;
    }
  })
  console.log(serviceRequests)
  
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
