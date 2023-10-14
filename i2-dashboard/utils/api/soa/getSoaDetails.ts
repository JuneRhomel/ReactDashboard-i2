import { ParamGetSoaDetailsType } from "@/types/apiRequestParams";
const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches the payment details of the user's current SOA.
* @param {ParamGetSoaDetailsType} params - This is a json object that has accountCode, dbTable, queryCondition, and resultLimit
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getSoaDetails(params: ParamGetSoaDetailsType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"): Promise<Response>{
    const url: string = `${process.env.API_URL}/tenant/get-list`;
    const method: string = 'POST';
    const body: string = JSON.stringify({
        accountcode: params.accountcode,
        table: 'soa_payment',
        condition: `soa_id=${params.soaId}`,
        limit: params.limit,
    });
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };
    try {
        const response: Response = await fetch(url, {
            method: method,
            headers: headers,
            body: body,
            referrerPolicy: "unsafe-url"
        });
        if (!response.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${response.status}, Response: ${JSON.stringify(await response.json())}`);
        }
        return response;
        
    } catch (error: any) {
        return error.message ? error.message : "Something went wrong";
    }
}