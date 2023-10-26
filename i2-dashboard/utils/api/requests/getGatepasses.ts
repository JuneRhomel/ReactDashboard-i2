import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import api from "..";
import mapObject from "@/utils/mapObject";
import { GatepassPersonnelType, GatepassType } from "@/types/models";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches all the user's Gate Passes
* @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<Response>} Returns a promise of a Response object.
*/
export async function getGatepasses(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<GatepassType[] | string>{
    let response: string | GatepassType[] = "Unable to fetch gatepass information";
    const getGatepassResponse = await api.requests.getServiceRequestDetails(params, 'gatepass', token);
    const getPersonnelResponse = await api.requests.getServiceRequestDetails(params, 'personnel', token);
    if (typeof getGatepassResponse != 'string') {
        const gatepasses = mapObject(await getGatepassResponse.json()) as GatepassType[];
        if (typeof getPersonnelResponse != 'string') {
            const personnel = mapObject(await getPersonnelResponse.json()) as GatepassPersonnelType[];
            gatepasses.map((gatepass)=> {
                const gatepassPersonnel = personnel.find((record)=> record.gatepassId === `${gatepass.id}`)
                gatepass.personnel = gatepassPersonnel || null;
            })
            response = gatepasses;
        }
    }
    return response;
}