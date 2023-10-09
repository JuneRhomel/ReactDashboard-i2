import Soa from "@/components/pages/soa/Soa";
import { ParamGetSoaType } from "@/types/models";
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";

export async function getServerSideProps(context: any) {
  //Fetch all the soa objects.
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt = context.req.cookies.token;
  const user = authorizeUser(jwt);
  const token = `${user?.token}:tenant`;
  const params: ParamGetSoaType = {
    accountcode: accountCode,
    userId: user?.tenantId as number,
  }

  const response = await api.soa.getSoa(params, token);
  const soas = await response.json();
  const currentSoa = soas.shift();
  // Filter what I need here
  return {
    props: {}
  }
}

export default Soa
