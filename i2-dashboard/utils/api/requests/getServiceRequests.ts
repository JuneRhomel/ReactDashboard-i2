import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import { ServiceRequestType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";
import getErrorObject from "../getErrorObject";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches the all the user's service requests
* @param {ParamGetServiceRequestType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<ApiResponse<ServiceRequestType[]>>} Returns a promise of an API response with either ServiceRequest data or errors.
*/
export async function getServiceRequests(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"): Promise<ApiResponse<ServiceRequestType[]>>{
    const url: string = `${process.env.API_URL}/tenant/get-allsr`;
    const method: string = 'POST';
    const body = {
        accountcode: params.accountcode,
        condition: `name_id=${params.userId}`,
        limit: params.limit,
    };
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };

    const response: ApiResponse<ServiceRequestType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    }

    try {
        const fetchResponse: Response = await fetch(url, {
            method: method,
            headers: headers,
            body: JSON.stringify(body),
            referrerPolicy: "unsafe-url"
        });
        const responseBody = await fetchResponse.json();
        if (!fetchResponse.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${fetchResponse.status}, Response: ${JSON.stringify(responseBody)}`);
        }
        if (responseBody.success == 0) {
            throw new Error(`HTTP Error! Status: 400 Bad Request. Response: ${JSON.stringify(responseBody.description)}`);
        }
        response.data = responseBody as ServiceRequestType[];       
    } catch (error: any) {
        const errorObject: ErrorType = getErrorObject(body, error.message);
        response.error = [errorObject];
    }

    response.success = !response.error;
    return response;
}