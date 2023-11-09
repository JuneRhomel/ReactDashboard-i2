import WorkPermit from "@/components/pages/workpermit/WorkPermit"
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";

export async function getServerSideProps(context: any) {
    const jwt = context.req.cookies.token;
    const user = authorizeUser(jwt);
    if (!user) {
       return {redirect : {destination: '/?error=accessDenied', permanent: false}};
    }
    const token = `${user.token}:tenant`;

    const getParams = {
      accountcode: process.env.TEST_ACCOUNT_CODE as string,
      userId: user.tenantId,
    }
    const workPermitsResponse = await api.requests.getWorkPermits(getParams, token, context);
    const workPermits = workPermitsResponse.data;
    const errors = workPermitsResponse.error || null;
    return {props: {authorizedUser: user, workPermits, errors}}
}

export default WorkPermit;