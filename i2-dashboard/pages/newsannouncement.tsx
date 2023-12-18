import authorizeUser from "@/utils/authorizeUser";
import NewsAnnouncement from "@/components/pages/newsannouncement/NewsAnnouncement";
import { ParamGetServiceRequestType, ParamGetSystemInfoType, ServiceRequestTable } from "@/types/apiRequestParams";
import { MyNewsAnnouncementsProps, NewsAnnouncementsType } from "@/types/models";
import api from "@/utils/api";
export async function getServerSideProps(context: any) {
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt: string = context?.req?.cookies?.token;
  const user = authorizeUser(jwt);
  if (!user) {
    return { redirect: { destination: '/?error=accessDenied', permanent: false } };
  }
  const token = `${user.token}:tenant`;
  const props: MyNewsAnnouncementsProps = {
    authorizedUser: user,
    newsAnnouncements: null,
    errors: null,
  }

  const accountcodeParam: ParamGetSystemInfoType = {
    accountcode: accountCode
  }
  
  const getNewsAnnouncementsResponse = await api.newsAnnouncements.getNewsAnnouncements(accountcodeParam, token);
  const newsAnnouncements = getNewsAnnouncementsResponse.success ? getNewsAnnouncementsResponse.data as NewsAnnouncementsType[] : undefined;
  props.newsAnnouncements = newsAnnouncements as NewsAnnouncementsType[];
  return {
    props: props
  }
}


export default NewsAnnouncement