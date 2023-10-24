import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import { GatePassType} from "@/types/models";
import Gatepass from "@/components/pages/gatepass/Gatepass";
import mapObject from "@/utils/mapObject";

export async function getServerSideProps(context: any){
  type PropsType = {
    error: string | null,
    gatePasses: GatePassType[] | null,
  }
  const props: PropsType = {error: null, gatePasses: null};
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt: string = context?.req?.cookies?.token;
  const user = authorizeUser(jwt);
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }
  const token = `${user.token}:tenant`

  const getGatePassesProps: ParamGetServiceRequestType = {
    accountcode: accountCode,
    userId: user.tenantId,
    // limit: 10,
  }

  const response = await api.requests.getGatePasses(getGatePassesProps, token);
  typeof response != 'string' ? props.gatePasses = response : props.error = response;
  return {
    props
  }
}

export default Gatepass