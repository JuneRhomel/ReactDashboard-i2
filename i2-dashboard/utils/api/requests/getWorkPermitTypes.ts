import { SelectDataType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import parseObject from "@/utils/parseObject";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"
/** 
* Fetches the options for work permit types.
* @param {string} token - This is the user token. Optional.
* @return {Promise<ApiResponse<SelectDataType[]>>} Returns a promise of a Response object.
*/
export async function getWorkPermitTypes(token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<ApiResponse<SelectDataType[]>>{
    const host = context?.req?.headers?.host || 'localhost:3000';
    const protocol = host === 'localhost:3000' ? 'http' : 'https';
    const apiUrl = '/api/requests/getGatepassTypes';
    const url = context ? `${protocol}://${host}${apiUrl}` : apiUrl;
    const method: string = 'POST';
    const body: string = JSON.stringify({
        table: 'list_workpermitcategory',
        orderby: 'category',
    });
    
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };

    const response: ApiResponse<SelectDataType[]> = {
        success: false,
        data: undefined,
        error: undefined
    }

    try {
        const fetchResponse: Response = await fetch(url, {
            method: method,
            headers: headers,
            body: body,
            referrerPolicy: "unsafe-url"
        });
        const jsonResponse = await fetchResponse.json();
        if (!fetchResponse.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${fetchResponse.status}, Response: ${JSON.stringify(jsonResponse)}`);
        }
        const issueCategories: SelectDataType[] = []
        jsonResponse.forEach((element: any) => {
            const category: SelectDataType = {
                id: element.id,
                name: element.category,
            }
            issueCategories.push(category);
        });
        response.success = true;
        response.data = issueCategories;
        
    } catch (error: any) {
        response.error = error.message;
    }

    return response;
}