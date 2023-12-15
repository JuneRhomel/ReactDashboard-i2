import { ParamGetSystemInfoType } from "@/types/apiRequestParams";
import { SystemInfoType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import parseObject from "@/utils/parseObject";
import axios, { AxiosResponse } from "axios";
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"
/** 
* Fetches the payment details of the a specific soa or all the soas.
* @param {ParamGetSystemInfoType} params - This is a json object that has accountCode, dbTable, queryCondition, and resultLimit
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getSysteminfo(
    getSystemInfoParams: ParamGetSystemInfoType,
    token = "c8c69a475a9715c2f2c6194bc1974fae:tenant"
): Promise<ApiResponse<SystemInfoType[]>> {
    const url = `${process.env.API_URL}/tenant/get-list`;
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };
    const response: ApiResponse<SystemInfoType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    };

    try {
        const axiosResponse: AxiosResponse = await axios.post(url, {
            accountcode: getSystemInfoParams.accountcode,
            table: 'system_info',
        }, {
            headers,
        });
        if (axiosResponse.status !== 200) {
            throw new Error(`HTTP error! Status: ${axiosResponse.status}, Response: ${JSON.stringify(axiosResponse.data)}`);
        }
        const responseBody = axiosResponse.data;
        if (responseBody && responseBody.success === 0) {
            throw new Error(`400 Bad Request! ${responseBody.description}`);
        }
        response.data = parseObject(responseBody) as SystemInfoType[];
        response.success = true;
        return response;
    } catch (error: any) {
        response.success = false;
        response.error = error.message;
        return {
            ...response
        };
    }
}