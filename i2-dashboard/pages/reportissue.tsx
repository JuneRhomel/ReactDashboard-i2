import ReportIssue from "@/components/pages/reportIssue/ReportIssue";
import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import { ServiceIssueType } from "@/types/models";
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";

export async function getServerSideProps(context:any) {
    const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
    const jwt: string = context?.req?.cookies?.token;
    const user = authorizeUser(jwt);
    if (!user) {
      return {redirect : {destination: '/?error=accessDenied', permanent: false}};
    }
    const token = `${user.token}:tenant`
    const getIssuesProps: ParamGetServiceRequestType = {
        accountcode: accountCode,
        userId: user.id,
        // limit: 10,
      }
    const issuesResponse = await api.requests.getIssues(getIssuesProps, token, context);
    const issues = issuesResponse.data || null;
    const errors = issuesResponse.error || null;
    return {props: {authorizedUser: user, issues, errors}}
}

export default ReportIssue;