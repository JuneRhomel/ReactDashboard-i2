import { ParamGetSystemInfoType } from "@/types/apiRequestParams";
import { SystemInfoType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import parseObject from "@/utils/parseObject";
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches the System Info for the Account property details.
* @param {ParamGetSystemInfoType} params - This is a json object that has accountCode, dbTable, queryCondition, and resultLimit
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getSysteminfo(params: ParamGetSystemInfoType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"): Promise<ApiResponse<SystemInfoType>> {
    const url: string = `${process.env.API_URL}/tenant/get-list`;
    const method: string = 'POST';
    const body: string = JSON.stringify({
        accountcode: params.accountcode,
        table: 'system_info',
    });
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };
    const response: ApiResponse<SystemInfoType> = {
        success: false,
        data: undefined,
        error: undefined,
    };
    try {
        const fetchResponse: Response = await fetch(url, {
            method,
            headers,
            body,
            referrerPolicy: "unsafe-url"
        });
        if (!fetchResponse.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${response.status}, Response: ${JSON.stringify(await fetchResponse.json())}`);
        }
        const responseBody = await fetchResponse.json();
        const systemInfo = responseBody.pop();

        if (systemInfo) {
            if (systemInfo.success === 0) {
                throw new Error(`400 Bad Request! ${systemInfo.description}`);
            }
            response.data = parseObject(systemInfo) as SystemInfoType;
        } else {
            response.data = null;
        }
        response.success = true;
        return response;
    } catch (error: any) {
        response.success = false;
        response.error = error.message;
        return response;
    }
}