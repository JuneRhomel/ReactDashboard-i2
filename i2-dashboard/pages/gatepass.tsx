import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import { GatepassType} from "@/types/models";
import Gatepass from "@/components/pages/gatepass/Gatepass";
import mapObject from "@/utils/mapObject";

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

export default Gatepass