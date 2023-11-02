import { ParamGatepassItemType, ParamGatepassPersonnelType, ParamSaveGatepassType } from "@/types/apiRequestParams";
import { CreateGatepassFormType, GatepassItemType, PersonnelDetailsType, SaveGatePassDataType } from "@/types/models";
import api from "..";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";
import getErrorObject from "../getErrorObject";
import postRequest from "../postRequest";

const url: string = '/api/requests/saveServiceRequest';
const method: string = 'POST';
const nameId = '1';
const unitId = '5';
const token = "c8c69a475a9715c2f2c6194bc1974fae:tenant";

/** 
* Saves the user's Gatepass request. It makes at least 3 api fetch requests.
* @param {CreateGatepassFormType} formData
* @return {Promise<ApiResponse>} Returns a promise of a Response object.
*/
export default async function saveGatepass(formData: CreateGatepassFormType, user=null): Promise<ApiResponse<SaveGatePassDataType>> {
    const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const module = 'gatepass';
    const personnel = formData.personnel as PersonnelDetailsType;
    const items = formData.items as GatepassItemType[];
    const error: ErrorType[] = [];
    const response: ApiResponse<SaveGatePassDataType> = {
        success: false,
        data: {
            personnelId: undefined,
            itemIds: [],
            gatepass: undefined,
        },
        error: undefined,
    }

    const gatepassDataBody: ParamSaveGatepassType = {
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

    const personnelDataBody: ParamGatepassPersonnelType = {
        gatepass_id: '',
        module: module,
        table: 'gatepass_personnel',
        company_name: personnel?.courier as string,
        personnel_name: personnel?.courierName as string,
        personnel_no: personnel?.courierContact as string,
    }
    
    console.log("Submitting Gatepass Request...")
    const gatepassResponse = await postRequest(gatepassDataBody, url);
    const gatepassId = gatepassResponse.id;
    if (gatepassId) {
        console.log("Gatepass was saved");
        const itemIds: number[] = [];
        const processItemsPromise = (async () => {
            await Promise.all(items.map(async (item) => {
                console.log("Submitting save item request...")
                const itemDataBody = {
                    item_name: item.itemName as string,
                    item_qty: item.itemQuantity?.toString() as string,
                    description: item.itemDescription as string,
                    gatepass_id: gatepassId,
                    table: 'gatepass_items',
                    module: module,
                }
                const itemResponse = await postRequest(itemDataBody, url);
                itemResponse.id ? itemIds.push(itemResponse.id) : error.push(getErrorObject(itemDataBody as ParamGatepassItemType, itemResponse));
                console.log(itemResponse.id ? "Item Saved" : "Item not saved");
            }))
        });

        personnelDataBody.gatepass_id = gatepassId

        const personnelResponsePromise = (async () => {
            console.log("Submitting Personnel save request");
            const personnelResponse = await postRequest(personnelDataBody, url);
            personnelResponse.id ? response.data ? response.data.personnelId = personnelResponse.id : null : error.push(getErrorObject(personnelDataBody as ParamGatepassPersonnelType, personnelResponse));
            console.log(personnelResponse.id ? "personnel saved" : "personnel not saved");
        })
        await Promise.all([processItemsPromise(), personnelResponsePromise()]);
        response.data ? response.data.itemIds = itemIds : null;
    } else {
        error.push(getErrorObject(gatepassDataBody as ParamSaveGatepassType, gatepassResponse));
    }
    response.success = error.length == 0;
    response.error = error;
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