import { ParamGetNews } from "@/types/apiRequestParams";
import { NewsAnnouncementsType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import parseObject from "@/utils/parseObject";
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches the all News Announcements 
* @param {ParamGetNews} params - This is a json object that has accountCode, dbTable, queryCondition, and resultLimit
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getNewsAnnouncements(params: ParamGetNews, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"): Promise<ApiResponse<NewsAnnouncementsType[]>>{
    const url: string = `${process.env.API_URL}/tenant/get-list`;
    const method: string = 'POST';
    const body: string = JSON.stringify({
        accountcode: params.accountcode,
        table: 'news',
    });
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };
    const response: ApiResponse<NewsAnnouncementsType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    }
    try {
        const fetchResponse: Response = await fetch(url, {
            method: method,
            headers: headers,
            body: body,
            referrerPolicy: "unsafe-url"
        });
        if (!fetchResponse.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${response.status}, Response: ${JSON.stringify(await fetchResponse.json())}`);
        }
        const responseBody = await fetchResponse.json();
        if (responseBody) {
            if (responseBody.success == 0) {
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
        return response
    }
}