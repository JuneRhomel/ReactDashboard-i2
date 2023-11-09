import MyRequests from "@/components/pages/myrequests/MyRequests";
import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import parseObject from "@/utils/parseObject";
import { GatepassPersonnelType, GatepassType, GuestType, MyRequestDataType, ServiceIssueType, ServiceRequestType, ServiceRequestsType, VisitorsPassType, WorkDetailType, WorkPermitType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";

export async function getServerSideProps(context: any){
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt: string = context?.req?.cookies?.token;
  const user = authorizeUser(jwt);
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }
  const token = `${user.token}:tenant`

  const getServiceRequestProps: ParamGetServiceRequestType = {
    accountcode: 'accountCode',
    userId: user.tenantId,
    limit: 10,
  }

  const response: ApiResponse<ServiceRequestType[]> = {
    success: false,
    data: undefined,
    error: undefined,
  }

  const serviceRequestPromise = api.requests.getServiceRequests(getServiceRequestProps, token);
  const gatepassPromise = api.requests.getGatepasses(getServiceRequestProps, token, context);
  const workPermitPromise = api.requests.getWorkPermits(getServiceRequestProps, token, context);
  const visitorPassPromise = api.requests.getVisitorPasses(getServiceRequestProps, token, context);
  const serviceIssuePromise = api.requests.getIssues(getServiceRequestProps, token, context);
  const [
    serviceRequestResponse,
    gatepassResponse,
    workPermitResponse,
    visitorPassResponse,
    serviceIssueResponse,
  ] = await Promise.all([
      serviceRequestPromise,
      gatepassPromise,
      workPermitPromise,
      visitorPassPromise,
      serviceIssuePromise
  ]);

  const errors: (ErrorType | string)[] = [];

  if (serviceRequestResponse.success == 0) {
    const error = serviceRequestResponse.error?.pop();
    errors.push(error as ErrorType);
  }
  if (gatepassResponse.success == 0) {
    const error = gatepassResponse.error?.pop();
    errors.push(error as string);
  }
  if (workPermitResponse.success == 0) {
    const error = workPermitResponse.error?.pop();
    errors.push(error as string);
  }
  if (visitorPassResponse.success == 0) {
    const error = visitorPassResponse.error?.pop();
    errors.push(error as string);
  }
  if (serviceIssueResponse.success == 0) {
    const error = serviceIssueResponse.error?.pop();
    errors.push(error as string);
  }
  console.log(errors)

  response.error = errors;
  const serviceRequests = parseObject(serviceRequestResponse.data as ServiceRequestType[]);

  // typeof response != 'string' ? jsonResponse = await response.json() : props.error = response;
  // const serviceRequests: ServiceRequestsType | null = jsonResponse ? parseObject(jsonResponse) as ServiceRequestsType : null;
  // serviceRequests?.sort((a: any, b: any) => parseInt(b.id) - parseInt(a.id));
  // const serviceRequestDetails: MyRequestDataType = {
  //   gatepasses: 'gatepass',
  //   personnel: 'personnel',
  //   serviceIssues: 'report_issue',
  //   workPermits: 'workpermit',
  //   workDetails: 'work_details',
  //   visitorPasses: 'visitor_pass',
  //   guests: 'vp_guest',
  // }
  // const keys = Object.keys(serviceRequestDetails);

  // await Promise.all(keys.map(async (key: string) => {
  //   const table= serviceRequestDetails[key as keyof MyRequestDataType] as string;
  //   const response = await api.requests.getServiceRequestDetails(getServiceRequestProps, table as ServiceRequestTable, token, context);
  //   const jsonResponse = typeof response != 'string' ? await response.json() : null;
  //   const obj = jsonResponse ? parseObject(jsonResponse) : response;
  //   serviceRequestDetails[key as keyof MyRequestDataType] = obj as [];
  // }))

  // serviceRequests && await Promise.all(serviceRequests.map((request: ServiceRequestType) => {
  //   if (request.type === "Gate Pass") {
  //     const gatepasses: GatepassType[] = serviceRequestDetails.gatepasses as GatepassType[];
  //     const personnel: GatepassPersonnelType[] = serviceRequestDetails.personnel as GatepassPersonnelType[];
  //     const gatepass: GatepassType | undefined = gatepasses.find((gatepass: GatepassType) => gatepass.id == request.id);
  //     // get the personnel details of the permit.
  //     if (gatepass) {
  //       const gatepassPersonnel: GatepassPersonnelType | undefined = personnel?.find((details: GatepassPersonnelType) => details.gatepassId === `${gatepass.id}`);
  //       gatepass.personnel = gatepassPersonnel ? gatepassPersonnel : null;
  //       request.data = gatepass;
  //     } else {
  //       request.data = null;
  //     }
  //   } else if (request.type === "Report Issue") {
  //     const serviceIssues: ServiceIssueType[] = serviceRequestDetails.serviceIssues as ServiceIssueType[];
  //     const serviceIssue: ServiceIssueType = serviceIssues?.find((serviceIssue: ServiceIssueType) => serviceIssue.id == request.id) as ServiceIssueType;
  //     request.data = serviceIssue;
  //   } else if (request.type === "Work Permit"){
  //     const workPermits: WorkPermitType[] = serviceRequestDetails.workPermits as WorkPermitType[];
  //     const workDetails: WorkDetailType[] = serviceRequestDetails.workDetails as WorkDetailType[];
  //     const workPermit: WorkPermitType | undefined = workPermits?.find((permit: WorkPermitType) => permit.id == request.id);
  //     if (workPermit) {
  //       const workDetail: WorkDetailType | undefined = workDetails?.find((detail: WorkDetailType) => detail.id === workPermit.workDetailsId) as WorkDetailType;
  //       workPermit.workDetail = workDetail ? workDetail : null;
  //       request.data = workPermit;
  //     } else {
  //       request.data = null;
  //     }
  //   } else if (request.type == "Visitor Pass") {
  //     const visitorPasses: VisitorsPassType[] = serviceRequestDetails.visitorPasses as VisitorsPassType[];
  //     const passGuests: GuestType[] = serviceRequestDetails.guests as GuestType[];
  //     const visitorPass: VisitorsPassType | undefined = visitorPasses.find((pass: any) => pass.id == request.id);
  //     if (visitorPass) {
  //       const guests: GuestType[] = passGuests.filter((guest: GuestType) => guest.guestId === visitorPass.id);
  //       visitorPass.guests = guests ? guests : null;
  //       request.data = visitorPass;
  //     } else {
  //       request.data = null;
  //     }
  //   }
  //   props.serviceRequests = serviceRequests as ServiceRequestsType;
  // }))
  return {
    props: {}
  }
}

export default MyRequests