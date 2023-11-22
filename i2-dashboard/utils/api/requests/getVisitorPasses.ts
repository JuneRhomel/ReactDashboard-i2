import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import api from "..";
import parseObject from "@/utils/parseObject";
import { GatepassPersonnelType, GatepassType, GuestType, VisitorsPassType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches all the user's Visitor Passes
* @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<ApiResponse<VisitorsPassType[]>>} Returns a promise of returning an API Response with success, data, and error properties.
*/
export async function getVisitorPasses(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<ApiResponse<VisitorsPassType[]>>{
    const response: ApiResponse<VisitorsPassType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    }

    const getVisitorPassResponse = await api.requests.getServiceRequestDetails(params, 'visitor_pass', token, context);
    const getGuestListResponse = await api.requests.getServiceRequestDetails(params, 'vp_guest', token, context);
    if (getVisitorPassResponse.success && getGuestListResponse.success) {
        const visitorPasses = parseObject(getVisitorPassResponse.data as VisitorsPassType[]);
        const guests = parseObject(getGuestListResponse.data as GuestType[]);
        await Promise.all(visitorPasses.map((visitorPass: VisitorsPassType)=> {
            const vpGuests = guests.filter((record: GuestType)=> record.guestId === visitorPass.id)
            visitorPass.guests = vpGuests || null;
        }))
        response.data = visitorPasses as VisitorsPassType[];
    } else {
        getVisitorPassResponse.error ? response.error = [...getVisitorPassResponse.error as string[]] : null;
        getGuestListResponse.error ? !response.error ? response.error = [...getGuestListResponse.error as string[]] : response.error = [...response.error as string[], ...getGuestListResponse.error as string[]] : null;
    }
    response.success = !response.error;
    return response;
}