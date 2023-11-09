import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import { GatepassType, VisitorsPassType} from "@/types/models";
import VisitorPass from "@/components/pages/visitorpass/VisitorPass";

export async function getServerSideProps(context: any){
    const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
    const jwt: string = context?.req?.cookies?.token;
    const user = authorizeUser(jwt);
    if (!user) {
      return {redirect : {destination: '/?error=accessDenied', permanent: false}};
    }
    const token = `${user.token}:tenant`
  
    const getVisitorPassProps: ParamGetServiceRequestType = {
      accountcode: accountCode,
      userId: user.tenantId,
      // limit: 10,
    }
  
    const visitorPassesResponse = await api.requests.getVisitorPasses(getVisitorPassProps, token, context);
    const visitorPasses = visitorPassesResponse.data as VisitorsPassType[] || null;
    const errors = visitorPassesResponse.error || null;
    return {
      props: {authorizedUser: user, visitorPasses, errors}
    }
  }
  
export default VisitorPass