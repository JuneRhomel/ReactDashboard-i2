import { ParamSaveGuestListType, ParamSaveVisitorPassType, RequestBodyType } from "@/types/apiRequestParams";
import { CreateVisitorPassFormDataType, GuestDataType, SaveServiceRequestResponseType, SaveVisitorPassDataType } from "@/types/models";
import api from "..";

const url: string = '/api/requests/saveServiceRequest';
const method: string = 'POST';
const nameId = '1';
const unitId = '5';
const token = "c8c69a475a9715c2f2c6194bc1974fae:tenant";

/** 
* Saves the user's Visitor Pass request.
* @param {CreateVisitorPassFormDataType} formData
* @return {Promise<SaveServiceRequestResponseType<SaveVisitorPassDataType>>} Returns a promise of a SaveServiceRequestResponse where the data is SaveVisitorPassData object.
*/
export default async function saveVisitorPass(formData: CreateVisitorPassFormDataType, user=null): Promise<SaveServiceRequestResponseType<SaveVisitorPassDataType>> {
    const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const module = 'visitorpass';
    const guests = formData.guests as GuestDataType[];
    const errors = [];
    const response: SaveServiceRequestResponseType<SaveVisitorPassDataType> = {
        success: false,
        data: {
            guestIds: undefined,
            visitorPass: undefined,
        },
        errors: undefined,
    }
    const visitorPassDataBody: ParamSaveVisitorPassType = {
        date: currentDate,
        module: module,
        table: 'visitorpass',
        name_id: nameId,
        unit_id: unitId,
        contact_no: formData.contactNumber as string,
        arrival_date: formData.arrivalDate as string,
        arrival_time: formData.arrivalTime as string,
        departure_date: formData.departureDate as string,
        departure_time: formData.departureTime as string,
    }

    console.log("Submitting Visitor Pass Request...")
    const visitorPassResponse = await postRequest(visitorPassDataBody);
    const visitorPassId = visitorPassResponse.id;
    if (visitorPassId) {
        console.log("Visitor Pass was saved");
        const guestIds: number[] = [];
        await Promise.all(guests.map(async (guest) => {
            console.log("Submitting save guest request...")
            const guestDataBody: ParamSaveGuestListType = {
                table: 'vp_guest',
                module: module,
                guest_id: visitorPassId,
                guest_name: guest.guestName as string,
                guest_purpose: guest.guestPurpose as string,
                guest_no: guest.guestContact as string
            }
            const guestResponse = await postRequest(guestDataBody);
            guestResponse.id ? guestIds.push(guestResponse.id) : errors.push(getErrorObject(guestDataBody as ParamSaveGuestListType, guestResponse));
            console.log(guestResponse.id ? "Guest Saved" : "Guest not saved");
        }));

        response.data.guestIds = guestIds;
    } else {
        errors.push(getErrorObject(visitorPassDataBody as ParamSaveVisitorPassType, visitorPassResponse));
    }
    response.success = errors.length == 0;
    response.errors = errors;
    const getVisitorPassParams = {
        accountcode: 'adminmailinatorcom',
        id: visitorPassId,
    }
    const newVisitorPassResponse = await api.requests.getVisitorPasses(getVisitorPassParams);
    const newVisitorPass = typeof newVisitorPassResponse !== 'string' ? newVisitorPassResponse.pop() : undefined;
    response.data.visitorPass = newVisitorPass;
    
    console.log(response);
    return response;
}

const getErrorObject = (requestBody: RequestBodyType, response: string) => {
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