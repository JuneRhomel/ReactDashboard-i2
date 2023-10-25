import { ParamSaveGatepassType } from "@/types/apiRequestParams";
import { CreateGatepassFormType } from "@/types/models";

const nameId = '1';
const unitId = '5';
const token = "c8c69a475a9715c2f2c6194bc1974fae:tenant";

/** 
* Saves the user's Gatepass request. It makes at least 3 api fetch requests.
* @param {CreateGatepassFormType} formData
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export default async function saveGatepass(formData: CreateGatepassFormType, user=null): Promise<Response> {
    const url: string = '/api/requests/saveGatepass';
    const method: string = 'POST';
    const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const module = 'gatepass';

    console.log(formData.gatepassType)
    const gatepassData: ParamSaveGatepassType = {
        date: currentDate,
        module: module,
        table: 'gatepass',
        name_id: nameId,
        unit_id: unitId,
        gp_type: formData.gatepassType as string,
        gp_date: formData.forDate as string,
        gp_time: formData.time as string,
        contact_no: formData.contactNumber as string,
    }
    
    const body = JSON.stringify({
        gatepassData: gatepassData
    });

    try {
        const response: Response = await fetch(url, {
            method: method,
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
    return new Response;
}