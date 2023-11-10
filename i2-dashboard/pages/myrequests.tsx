import MyRequests from "@/components/pages/myrequests/MyRequests";
import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import parseObject from "@/utils/parseObject";
import { GatepassPersonnelType, GatepassType, GuestType, MyRequestDataType, ServiceIssueType, ServiceRequestDataType, ServiceRequestType, ServiceRequestsType, UserType, VisitorsPassType, WorkDetailType, WorkPermitType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";

type MyRequestProps = {
  authorizedUser: UserType,
  serviceRequests: ServiceRequestType[] | null,
  errors: any[] | null,
}

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
    userId: user.id,
    limit: 50,
  }

  const props: MyRequestProps = {
    authorizedUser: user,
    serviceRequests: null,
    errors: null,
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

  const responses = [serviceRequestResponse, gatepassResponse, workPermitResponse, visitorPassResponse, serviceIssueResponse]
  const errors: (ErrorType | string)[] = [];

  responses.forEach((apiResponse) => {
    if (!apiResponse.success) {
      const error = apiResponse.error as (ErrorType | string)[];
      error && errors.push(...error);
    }
  })

  if (errors.length == 0) {
    // no errors
    const serviceRequests = parseObject(responses?.shift()?.data as ServiceRequestType[]) as ServiceRequestType[];
    const gatepasses = parseObject(responses?.shift()?.data as GatepassType[]) as GatepassType[];
    const workPermits = parseObject(responses?.shift()?.data as WorkPermitType[]) as WorkPermitType[];
    const visitorPasses = parseObject(responses?.shift()?.data as VisitorsPassType[]) as VisitorsPassType[];
    const serviceIssues = parseObject(responses?.shift()?.data as ServiceIssueType[]) as ServiceIssueType[];
    serviceRequests.sort((a, b) => {
      const aDate: Date = new Date(a.dateUpload);
      const bDate: Date = new Date(b.dateUpload);
      return bDate.getTime() - aDate.getTime();
    });
    serviceRequests.splice(10);
    const requestDetails = new Map<string, ServiceRequestDataType[]>([
      ['Gate Pass', gatepasses],
      ['Work Permit', workPermits],
      ['Visitor Pass', visitorPasses],
      ['Report Issue', serviceIssues]
    ]);
    serviceRequests?.forEach((request: ServiceRequestType) => {
      console.log(request);
      const type = request.type;
      const details = requestDetails.get(type);
      const requestData = details?.find((detail: ServiceRequestDataType) => detail?.id === request.id);
      request.data = requestData || null;
    })
    props.serviceRequests = serviceRequests;
  } else {
    // error case
    props.errors = errors;
  }

  return {
    props: props
  }
}

export default MyRequests