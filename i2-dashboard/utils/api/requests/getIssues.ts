import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import api from "..";
import parseObject from "@/utils/parseObject";
import { ServiceIssueType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches all the user's Service Issues
* @param {ParamGetServiceRequestType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<ApiResponse<ServiceIssueType[]>>} Returns a promise of a Response object.
*/
export async function getIssues(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<ApiResponse<ServiceIssueType[] | null>>{
    const response: ApiResponse<ServiceIssueType[] | null> = {
        success: false,
        data: undefined,
        error: undefined,
    }

    const getIssuesResponse = await api.requests.getServiceRequestDetails(params, 'report_issue', token, context);
    const responseBody = await getIssuesResponse.json();
    if (getIssuesResponse.ok) {
        response.success = true;
        if (responseBody !== null) {
            const serviceIssues = parseObject(responseBody) as ServiceIssueType[];
            response.data = serviceIssues;
        } else {
            response.data = null;
        }
    } else {
        response.error = responseBody;
    }
    return response;
}