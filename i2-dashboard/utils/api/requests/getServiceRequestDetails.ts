import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import { useRouter } from "next/router";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"
/** 
 * Fetches all the user's Gate Passes
 * @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
 * @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getServiceRequestDetails(params: ParamGetServiceRequestType, table: ServiceRequestTable, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<Response>{
    const protocol = context?.req?.protocol || 'http';
    const host = context?.req?.headers?.host || 'localhost:3000';
    const apiUrl = '/api/requests/getservicerequestdetails';
    const url = `${protocol}://${host}${apiUrl}`;
    const method: string = 'POST';
    const condition = params.id ? `id=${params.id}` : `name_id=${params.userId}`;
    const body: string = JSON.stringify({
        accountcode: params.accountcode,
        table: table === 'personnel' ? 'gatepass_personnel'
                : table === 'vp_guest' ? 'vp_guest'
                : table === 'work_details' ? 'work_details'
                : `vw_${table}`,
        condition: table === 'personnel' || table === 'vp_guest' || table === 'work_details' ? null : condition,
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
        console.log(error.message)
        return error.message ? error.message : "Something went wrong";
    }
}