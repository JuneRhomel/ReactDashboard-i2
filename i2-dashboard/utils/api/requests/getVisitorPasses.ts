import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import api from "..";
import mapObject from "@/utils/mapObject";
import { GatepassPersonnelType, GatepassType, GuestType, VisitorsPassType } from "@/types/models";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches all the user's Visitor Passes
* @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<VisitorPassType[] | string>} Returns a promise of returning an array of VisitorPasses or a string with an error.
*/
export async function getVisitorPasses(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<VisitorsPassType[] | string>{
    let response: string | VisitorsPassType[] = "Unable to fetch visitor pass information";
    const getVisitorPassResponse = await api.requests.getServiceRequestDetails(params, 'visitor_pass', token, context);
    const getGuestListResponse = await api.requests.getServiceRequestDetails(params, 'vp_guest', token, context);
    if (typeof getVisitorPassResponse != 'string') {
        const visitorPasses = mapObject(await getVisitorPassResponse.json()) as VisitorsPassType[];
        if (typeof getGuestListResponse != 'string') {
            const guests = mapObject(await getGuestListResponse.json()) as GuestType[];
            visitorPasses.map((visitorPass)=> {
                const vpGuests = guests.filter((record)=> record.guestId === `${visitorPass.id}`)
                visitorPass.guests = vpGuests || null;
            })
            response = visitorPasses;
        }
    }
    return response;
}