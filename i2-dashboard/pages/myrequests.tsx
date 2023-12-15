import MyRequests from "@/components/pages/myrequests/MyRequests";
import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import { MyRequestProps } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import parseObject from "@/utils/parseObject";
import { GatepassPersonnelType, GatepassType, GuestType, MyRequestDataType, ServiceIssueType, ServiceRequestDataType, ServiceRequestType, ServiceRequestsType, UserType, VisitorsPassType, WorkDetailType, WorkPermitType } from "@/types/models";
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
    accountcode: accountCode,
    userId: user.id,
    limit: 10,
  }

  const props: MyRequestProps = {
    authorizedUser: user,
    serviceRequests: null,
    errors: null,
  }

  const serviceRequestResponse = await api.requests.getServiceRequests(getServiceRequestProps, token, context);
  console.log(serviceRequestResponse)
  serviceRequestResponse.success ?
      props.serviceRequests = serviceRequestResponse.data as ServiceRequestType[] :
        props.errors = serviceRequestResponse.error as (string|ErrorType)[];

  return {
    props: props
  }
}

export default MyRequests