import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import mapObject from "@/utils/mapObject";
import { GatePassPersonnelType, GatePassType, GuestType, MyRequestDataType, ServiceIssueType, ServiceRequestType, ServiceRequestsType, VisitorsPassType, WorkDetailType, WorkPermitType } from "@/types/models";
import Gatepass from "@/components/pages/gatepass/Gatepass";

export async function getServerSideProps(context: any){
  type PropsType = {
    error: string | null,
    serviceRequests: ServiceRequestsType | null,
  }
  let props: PropsType = {error: null, serviceRequests: null};
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
    limit: 10,
  }

  let jsonResponse;
  let response = await api.requests.getServiceRequests(getServiceRequestProps, token);
  typeof response != 'string' ? jsonResponse = await response.json() : props.error = response;
  const serviceRequests: ServiceRequestsType | null = jsonResponse ? mapObject(jsonResponse) as ServiceRequestsType : null;
  serviceRequests?.sort((a: any, b: any) => parseInt(b.id) - parseInt(a.id));
  const serviceRequestDetails: MyRequestDataType = {
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
    const table: string = serviceRequestDetails[key as keyof MyRequestDataType] as string;
    const response = await api.requests.getServiceRequestDetails(getServiceRequestProps, table, token);
    const jsonResponse = typeof response != 'string' ? await response.json() : null;
    const obj = jsonResponse ? mapObject(jsonResponse) : response;
    serviceRequestDetails[key as keyof MyRequestDataType] = obj as [];
  }))

  serviceRequests && await Promise.all(serviceRequests.map((request: ServiceRequestType) => {
    if (request.type === "Gate Pass") {
      const gatePasses: GatePassType[] = serviceRequestDetails.gatePasses as GatePassType[];
      const personnel: GatePassPersonnelType[] = serviceRequestDetails.personnel as GatePassPersonnelType[];
      const gatePass: GatePassType | undefined = gatePasses.find((gatePass: GatePassType) => gatePass.id == request.id);
      // get the personnel details of the permit.
      if (gatePass) {
        const gatePassPersonnel: GatePassPersonnelType | undefined = personnel?.find((details: GatePassPersonnelType) => details.gatepassId === `${gatePass.id}`);
        gatePass.personnel = gatePassPersonnel ? gatePassPersonnel : null;
        request.data = gatePass;
      } else {
        request.data = null;
      }
    } else if (request.type === "Report Issue") {
      const serviceIssues: ServiceIssueType[] = serviceRequestDetails.serviceIssues as ServiceIssueType[];
      const serviceIssue: ServiceIssueType = serviceIssues?.find((serviceIssue: ServiceIssueType) => serviceIssue.id == request.id) as ServiceIssueType;
      request.data = serviceIssue;
    } else if (request.type === "Work Permit"){
      const workPermits: WorkPermitType[] = serviceRequestDetails.workPermits as WorkPermitType[];
      const workDetails: WorkDetailType[] = serviceRequestDetails.workDetails as WorkDetailType[];
      const workPermit: WorkPermitType | undefined = workPermits?.find((permit: WorkPermitType) => permit.id == request.id);
      if (workPermit) {
        const workDetail: WorkDetailType | undefined = workDetails?.find((detail: WorkDetailType) => detail.id === workPermit.workDetailsId) as WorkDetailType;
        workPermit.workDetail = workDetail ? workDetail : null;
        request.data = workPermit;
      } else {
        request.data = null;
      }
    } else if (request.type == "Visitor Pass") {
      const visitorPasses: VisitorsPassType[] = serviceRequestDetails.visitorPasses as VisitorsPassType[];
      const passGuests: GuestType[] = serviceRequestDetails.guests as GuestType[];
      const visitorPass: VisitorsPassType | undefined = visitorPasses.find((pass: any) => pass.id == request.id);
      if (visitorPass) {
        const guests: GuestType[] = passGuests.filter((guest: GuestType) => guest.guestId === visitorPass.id);
        visitorPass.guests = guests ? guests : null;
        request.data = visitorPass;
      } else {
        request.data = null;
      }
    }

    props.serviceRequests = serviceRequests as ServiceRequestsType;
  }))
  return {
    props
  }
}

export default Gatepass