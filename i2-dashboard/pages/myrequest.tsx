import Layout from "@/components/layouts/layout";
import Section from "@/components/general/section/Section";
import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
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
  let response = await api.requests.getServiceRequests(getServiceRequestProps, token);
  let jsonResponse = await response.json();
  const serviceRequests = jsonResponse && mapObject(jsonResponse);
  serviceRequests.sort((a: any, b: any) => a.id - b.id);
  
  type dataType = {
    gatePasses: [] | string,
    personnel: [] | string,
    serviceIssues: [] | string,
    workPermits: [] | string,
    workDetails: [] | string,
    visitorPasses: [] | string,
    guests: [] | string,
  }
  const serviceRequestDetails: dataType = {
    gatePasses: 'gatepass',
    personnel: 'personnel',
    serviceIssues: 'report_issue',
    workPermits: 'workpermit',
    workDetails: 'work_details',
    visitorPasses: 'visitor_pass',
    guests: 'vp_guest',
  }
  const keys = Object.keys(serviceRequestDetails);

  await Promise.all(keys.map(async (key: string) => {
    const table: string = serviceRequestDetails[key as keyof dataType] as string;
    const response = await api.requests.getServiceRequestDetails(getServiceRequestProps, table, token);
    const jsonResponse = typeof response != 'string' ? await response.json() : null;
    const obj = jsonResponse ? mapObject(jsonResponse) : response;
    serviceRequestDetails[key as keyof dataType] = obj as [];
  }))

  await Promise.all(serviceRequests.map((request: any) => {
    if (request.type === "Gate Pass") {
      const gatePasses: any = serviceRequestDetails.gatePasses;
      const personnel: any = serviceRequestDetails.personnel;
      const gatePass = gatePasses.find((gatePass: any) => gatePass.id == request.id);
      // get the personnel details of the permit.
      if (gatePass) {
        const gatePassPersonnel = personnel?.find((details: any) => details.gatepassId === `${gatePass.id}`);
        gatePass.personnel = gatePassPersonnel ? gatePassPersonnel : null;
        request.gatePass = gatePass;
      } else {
        request.gatePass = null;
      }
    } else if (request.type === "Report Issue") {
      const serviceIssues: any = serviceRequestDetails.serviceIssues;
      const serviceIssue = serviceIssues?.find((serviceIssue: any) => serviceIssue.id == request.id);
      request.serviceIssue = serviceIssue;
    } else if (request.type === "Work Permit"){
      const workPermits: any = serviceRequestDetails.workPermits;
      const workDetails: any = serviceRequestDetails.workDetails;
      const workPermit = workPermits?.find((permit: any) => permit.id == request.id);
      if (workPermit) {
        const workDetail = workDetails?.find((detail: any) => detail.id == parseInt(workPermit.workDetailsId));
        workPermit.workDetail = workDetail;
        request.workPermit = workPermit;
      } else {
        request.workPermit = null;
      }
    } else if (request.type == "Visitor Pass") {
      const visitorPasses: any = serviceRequestDetails.visitorPasses;
      const passGuests: any = serviceRequestDetails.guests;
      const visitorPass = visitorPasses.find((pass: any) => pass.id == request.id);
      if (visitorPass) {
        const guests = passGuests.filter((guest: any) => parseInt(guest.guestId) == (visitorPass.id));
        visitorPass.guests = guests;
        request.visitorPass = visitorPass;
      } else {
        request.visitorPass = null;
      }
    }
  }))
  
  return {
    props: {serviceRequests, serviceRequestDetails}
    // props: {}
  }
}

export default function myrequest({serviceRequests}: {serviceRequests: any}) {
  const props = {
    title: "Requests",
    headerAction: null,
    data: serviceRequests
  }
  
  return (
    <Layout title='i2 - Requests'>
      <Section props={props}/>
      {JSON.stringify(serviceRequests)}
    </Layout>
  )
}
