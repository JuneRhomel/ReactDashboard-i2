import { GatepassTypeType } from "@/types/models";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"
/** 
* Fetches the options for Gatepass types.
* @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getGatepassTypes(token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<GatepassTypeType[] | string>{
    const protocol = context?.req?.protocol || 'http';
    const host = context?.req?.headers?.host || 'localhost:3000';
    const apiUrl = '/api/requests/getGatepassTypes';
    const url = `${protocol}://${host}${apiUrl}`;
    const method: string = 'POST';
    const body: string = JSON.stringify({
        table: 'list_gatepasscategory',
        orderby: 'category_name',
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
        const gatepassTypes: any[] = []
        const jsonResponse = await response.json();
        jsonResponse.forEach((element: any) => {
            const gatepassType = {
                id: element.id,
                categoryName: element.category_name,
            }
            gatepassTypes.push(gatepassType);
        });
        return gatepassTypes;
        
    } catch (error: any) {
        return error.message ? error.message : "Something went wrong";
    }
}