import { ParamGatepassItemType, ParamGatepassPersonnelType, ParamSaveGatepassType } from "@/types/apiRequestParams";
import { CreateGatepassFormType, GatepassDisplayType, GatepassItemType, GatepassPersonnelType, GatepassType, PersonnelDetailsType, SaveGatePassDataType, SaveGatePassResponseType } from "@/types/models";
import getDateTimeString from "@/utils/getDateTimeString";
import api from "..";

const url: string = '/api/requests/saveGatepass';
const method: string = 'POST';
const nameId = '1';
const unitId = '5';
const token = "c8c69a475a9715c2f2c6194bc1974fae:tenant";

/** 
* Saves the user's Gatepass request. It makes at least 3 api fetch requests.
* @param {CreateGatepassFormType} formData
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export default async function saveGatepass(formData: CreateGatepassFormType, user=null): Promise<SaveGatePassResponseType> {
    const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const module = 'gatepass';
    const personnel = formData.personnel as PersonnelDetailsType;
    const items = formData.items as GatepassItemType[];
    const errors = [];
    const response: SaveGatePassResponseType = {
        success: false,
        data: {
            personnelId: undefined,
            itemIds: [],
            gatepass: undefined,
        },
        errors: undefined,
    }

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

    const personnelData: ParamGatepassPersonnelType = {
        gatepass_id: '',
        module: module,
        table: 'gatepass_personnel',
        company_name: personnel?.courier as string,
        personnel_name: personnel?.courierName as string,
        personnel_no: personnel?.courierContact as string,
    }
    
    const gatepassDataBody = {
        gatepassData: gatepassData,
    };

    console.log("Submitting Gatepass Request...")
    const gatepassResponse = await postRequest(gatepassDataBody);
    const gatepassId = gatepassResponse.id;
    if (gatepassId) {
        console.log("Gatepass was saved");
        const itemIds: number[] = [];
        const processItemsPromise = (async () => {
            await Promise.all(items.map(async (item) => {
                console.log("Submitting save item request...")
                const itemDataBody = {
                    itemData: {
                        item_name: item.itemName as string,
                        item_qty: item.itemQuantity?.toString() as string,
                        description: item.itemDescription as string,
                        gatepass_id: gatepassId,
                        table: 'gatepass_items',
                        module: module,
                    }
                }
                const itemResponse = await postRequest(itemDataBody);
                itemResponse.id ? itemIds.push(itemResponse.id) : errors.push(getErrorObject(itemDataBody.itemData as ParamGatepassItemType, itemResponse));
                console.log(itemResponse.id ? "Item Saved" : "Item not saved");
            }))
        });

        const personnelDataBody = {
            personnelData: {...personnelData, gatepass_id: gatepassId}
        }
        const personnelResponsePromise = (async () => {
            console.log("Submitting Personnel save request");
            const personnelResponse = await postRequest(personnelDataBody);
            personnelResponse.id ? response.data ? response.data.personnelId = personnelResponse.id : null : errors.push(getErrorObject(personnelDataBody.personnelData as ParamGatepassPersonnelType, personnelResponse));
            console.log(personnelResponse.id ? "personnel saved" : "personnel not saved");
        })
        await Promise.all([processItemsPromise(), personnelResponsePromise()]);
        response.data ? response.data.itemIds = itemIds : null;
    } else {
        errors.push(getErrorObject(gatepassDataBody.gatepassData as ParamSaveGatepassType, gatepassResponse));
    }
    response.success = errors.length == 0;
    response.errors = errors;
    const getGatepassParams = {
        accountcode: 'adminmailinatorcom',
        id: gatepassId,
    }
    const newGatepassResponse = await api.requests.getGatepasses(getGatepassParams)
    const newGatepass = typeof newGatepassResponse !== 'string' ? newGatepassResponse.pop() : undefined;
    response.data ? response.data.gatepass = newGatepass : null;
    
    console.log(response);
    return response;
}

const getErrorObject = (requestBody: ParamSaveGatepassType | ParamGatepassItemType | ParamGatepassPersonnelType, response: string) => {
    const newError = {
        message: response,
        data: requestBody,
    }
    return newError;
}

const postRequest = (async (body: any) => {
    try {
        const response: Response = await fetch(url, {
            method: method,
            body: JSON.stringify(body),
            referrerPolicy: "unsafe-url"
        });
        if (!response.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${response.status}, Response: ${JSON.stringify(await response.json())}`);
        }
        return await response.json();
        
    } catch (error: any) {
        return error.message ? error.message : "Something went wrong";
    }
})