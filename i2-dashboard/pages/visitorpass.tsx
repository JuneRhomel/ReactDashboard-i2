import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import { GatepassType, VisitorsPassType} from "@/types/models";
import VisitorPass from "@/components/pages/visitorpass/VisitorPass";

// export async function getServerSideProps(context: any){
//   type PropsType = {
//     error: string | null,
//     visitorPasses: VisitorsPassType[] | null,
//   }
//   const props: PropsType = {error: null, visitorPasses: null};
//   const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
//   const jwt: string = context?.req?.cookies?.token;
//   const user = authorizeUser(jwt);
//   if (!user) {
//     return {redirect : {destination: '/?error=accessDenied', permanent: false}};
//   }
//   const token = `${user.token}:tenant`

//   const getVisitorPassesProps: ParamGetServiceRequestType = {
//     accountcode: accountCode,
//     userId: user.tenantId,
//     // limit: 10,
//   }

// //   const visitorPasses = await api.requests.getGatepasses(getGatepassesProps, token, context);
// //   typeof gatepasses != 'string' ? props.visitorPasses = gatepasses : props.error = gatepasses;
//   return {
//     props
//   }
// }

export async function getServerSideProps(context: any){
    type PropsType = {
      error: string | null,
      gatepasses: GatepassType[] | null,
      gatepassTypes: any;
    }
    const props: PropsType = {error: null, gatepasses: null, gatepassTypes: null};
    const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
    const jwt: string = context?.req?.cookies?.token;
    const user = authorizeUser(jwt);
    if (!user) {
      return {redirect : {destination: '/?error=accessDenied', permanent: false}};
    }
    const token = `${user.token}:tenant`
  
    const getGatepassesProps: ParamGetServiceRequestType = {
      accountcode: accountCode,
      userId: user.tenantId,
      // limit: 10,
    }
  
    const gatepasses = await api.requests.getGatepasses(getGatepassesProps, token, context);
    typeof gatepasses != 'string' ? props.gatepasses = gatepasses : props.error = gatepasses;
    return {
      props
    }
  }
  

export default VisitorPass