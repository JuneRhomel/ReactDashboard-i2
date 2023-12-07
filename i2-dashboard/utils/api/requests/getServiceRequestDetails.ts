import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import { ApiResponse } from "@/types/responseWrapper";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
 * Fetches all the user's Gate Passes
 * @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
 * @return {Promise<ApiResponse<any[]>>} Returns a promise of a Response object.
*/
export async function getServiceRequestDetails(params: ParamGetServiceRequestType, table: ServiceRequestTable, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<ApiResponse<any[]>>{
    const host = context?.req?.headers?.host || 'localhost:3000';
    const protocol = host === 'localhost:3000' ? 'http' : 'https';
    const apiUrl = '/api/requests/getservicerequestdetails';
    const url = context ? `${protocol}://${host}${apiUrl}` : apiUrl;
    const method: string = 'POST';
    const condition = params.id ? `id=${params.id}` : `name_id=${params.userId}`;
    const body: string = JSON.stringify({
        accountcode: params.accountcode,
        table: table === 'personnel' ? 'gatepass_personnel'
                : table === 'vp_guest' ? 'vp_guest'
                : table === 'work_details' ? 'work_details'
                : table === 'comments' ? 'comments'
                : `vw_${table}`,
        condition: table === 'personnel' || table === 'vp_guest' || table === 'work_details' ? null : condition,
        limit: params.limit,
    });
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };

    const response: ApiResponse<any[]> = {
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
        const responseBody = await fetchResponse.json();
        if (!fetchResponse.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${response.status}, Response: ${JSON.stringify(responseBody)}`);
        }
        response.data = responseBody;
    } catch (error: any) {
        response.error = [error.message || "Unable to fetch service request details"];
    }

    response.success = !response.error
    return response;
}