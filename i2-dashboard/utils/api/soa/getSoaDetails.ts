import { ParamGetSoaDetailsType } from "@/types/apiRequestParams";
import { SoaDetailsType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches the payment details of the a specific soa or all the soas.
* @param {ParamGetSoaDetailsType} params - This is a json object that has accountCode, dbTable, queryCondition, and resultLimit
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getSoaDetails(params: ParamGetSoaDetailsType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"): Promise<ApiResponse<SoaDetailsType[]>>{
    const url: string = `${process.env.API_URL}/tenant/get-list`;
    const method: string = 'POST';
    const body: string = JSON.stringify({
        accountcode: params.accountcode,
        table: 'soa_payment',
        condition: params.soaId ? `soa_id=${params.soaId}` : undefined,
        limit: params.limit,
    });
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };
    const response: ApiResponse<SoaDetailsType[]> = {
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
        response.success = true;
        response.data = await fetchResponse.json();
        return response;
        
    } catch (error: any) {
        response.success = false;
        response.error = error;
        return response
    }
}