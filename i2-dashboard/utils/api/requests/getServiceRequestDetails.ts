import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import { ApiResponse } from "@/types/responseWrapper";
import axios, { AxiosRequestConfig, AxiosResponse } from "axios";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
 * Fetches all the user's Gate Passes
 * @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
 * @return {Promise<ApiResponse<any[]>>} Returns a promise of a Response object.
*/
export async function getServiceRequestDetails(requestParams: ParamGetServiceRequestType, tableName: ServiceRequestTable, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<ApiResponse<any[]>> {
    const host = context?.req?.headers?.host || 'localhost:3000';
    const protocol = host === 'localhost:3000' ? 'http' : 'https';
    const apiUrl = '/api/requests/getservicerequestdetails';
    const url = `${process.env.API_URL}/tenant/get-list`;

    const body = {
        accountcode: requestParams.accountcode,
        table: tableName === 'personnel' ? 'gatepass_personnel'
            : tableName === 'vp_guest' ? 'vp_guest'
                : tableName === 'work_details' ? 'work_details'
                    : `vw_${tableName}`,
        condition: tableName === 'personnel' || tableName === 'vp_guest' || tableName === 'work_details' ? null : (requestParams.id ? `id=${requestParams.id}` : `name_id=${requestParams.userId}`),
        limit: requestParams.limit,
    };

    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };
    const response: ApiResponse<any[]> = {
        success: false,
        data: undefined,
        error: undefined,
    };

    try {
        const fetchResponse: AxiosResponse = await axios.post(url, body, {
            headers,
            timeout: 30000,
        });
        if (fetchResponse.status !== 200) {
            throw new Error(`HTTP error! Status: ${fetchResponse.status}, Response: ${JSON.stringify(fetchResponse.data)}`);
        }
        response.data = fetchResponse.data;
    } catch (error: any) {
        response.error = [error.message || "Unable to fetch service request details"];
    }

    response.success = !response.error;
    return response;
}