import { ParamGetNews } from "@/types/apiRequestParams";
import { NewsAnnouncementsType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import parseObject from "@/utils/parseObject";
import axios, { AxiosRequestConfig, AxiosResponse } from 'axios';
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
 * Fetches all News Announcements 
 * @param {ParamGetNews} params - JSON object with accountCode, dbTable, queryCondition, and resultLimit
 * @param {string} token - Authorization token (default value: "c8c69a475a9715c2f2c6194bc1974fae:tenant")
 * @return {Promise<ApiResponse<NewsAnnouncementsType[]>>} Promise of a Response object
 */
export async function getNewsAnnouncements(params: ParamGetNews, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"): Promise<ApiResponse<NewsAnnouncementsType[]>> {
  const url = `${process.env.API_URL}/tenant/get-list`;
  const headers: AxiosRequestConfig = {
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`,
    },
    timeout: 50000
  };
  const response: ApiResponse<NewsAnnouncementsType[]> = {
    success: false,
    data: undefined,
    error: undefined,
  };

  try {
    const axiosResponse: AxiosResponse = await axios.post(url, {
      accountcode: params.accountcode,
      table: 'news',
    }, headers);

    const responseBody = axiosResponse.data;
    if (responseBody) {
      if (responseBody.success === 0) {
        throw new Error(`400 Bad Request! ${responseBody.description}`);
      }
      response.data = parseObject(responseBody) as NewsAnnouncementsType[];
    } else {
      response.data = null;
    }
    response.success = true;
    return response;
  } catch (error: any) {
    response.success = false;
    response.error = error.message;
    return {
      ...response}
      ;
  }
}