import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import api from "@/utils/api";
import { GatepassType} from "@/types/models";
import Gatepass from "@/components/pages/gatepass/Gatepass";
import parseObject from "@/utils/parseObject";

export async function getServerSideProps(context: any){
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt: string = context?.req?.cookies?.token;
  const user = authorizeUser(jwt);
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }
  const token = `${user.token}:tenant`

  const getGatepassesProps: ParamGetServiceRequestType = {
    accountcode: accountCode,
    userId: user.id,
    // limit: 10,
  }

  const gatepassesResponse = await api.requests.getGatepasses(getGatepassesProps, token, context);
  const gatepasses = gatepassesResponse.data || null;
  const errors = gatepassesResponse.error || null;
  return {
    props: {authorizedUser: user, gatepasses, errors}
  }
}

export default Gatepass