import { ParamGetServiceRequestType, ServiceRequestTable } from "@/types/apiRequestParams";
import api from "..";
import parseObject from "@/utils/parseObject";
import { GatepassPersonnelType, GatepassType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches all the user's Gate Passes
* @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<ApiResponse<GatepassType[]>>} Returns a promise of returning an API Response with success, data, and error properties.
*/
export async function getGatepasses(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<ApiResponse<GatepassType[]>>{
    const response: ApiResponse<GatepassType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    }
    const getGatepassResponse = await api.requests.getServiceRequestDetails(params, 'gatepass', token, context);
    const getPersonnelResponse = await api.requests.getServiceRequestDetails(params, 'personnel', token, context);
    if (getGatepassResponse.success && getPersonnelResponse.success) {
        const gatepasses = parseObject(getGatepassResponse.data as GatepassType[]) as GatepassType[];
        const personnel = parseObject(getPersonnelResponse.data as GatepassPersonnelType[]) as GatepassPersonnelType[];
        await Promise.all(gatepasses.map((gatepass: GatepassType)=> {
            const gatepassPersonnel = personnel.find((record: GatepassPersonnelType)=> record.gatepassId === gatepass.id)
            gatepass.personnel = gatepassPersonnel || null;
        }))
        response.data = gatepasses as GatepassType[];
    } else {
        getGatepassResponse.error ? response.error = [...getGatepassResponse.error as string[]] : null;
        getPersonnelResponse.error ? !response.error ? response.error = [...getPersonnelResponse.error as string[]] : response.error = [...response.error as string[], ...getPersonnelResponse.error as string[]] : null;
    }
    response.success = !response.error;
    return response;
}