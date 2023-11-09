import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import api from "..";
import parseObject from "@/utils/parseObject";
import { GatepassPersonnelType, GatepassType, GuestType, VisitorsPassType, WorkDetailType, WorkPermitType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches all the user's Work Permit Requests
* @param {ParamGetServiceRequestDetailsType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<ApiResponse<WorkPermitType[]>>} Returns a promise of returning an API Response with success, data, and error properties.
*/
export async function getWorkPermits(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any = undefined): Promise<ApiResponse<WorkPermitType[]>>{
    const response: ApiResponse<WorkPermitType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    }
    const getWorkPermitResponse = await api.requests.getServiceRequestDetails(params, 'workpermit', token, context);
    const getWorkDetailsResponse = await api.requests.getServiceRequestDetails(params, 'work_details', token, context);
    if (getWorkPermitResponse.success && getWorkDetailsResponse.success) {
        const workPermits = parseObject(getWorkPermitResponse.data as WorkPermitType[]);
        const workDetails = parseObject(getWorkDetailsResponse.data as WorkDetailType[]);
        await Promise.all(workPermits.map((workPermit: WorkPermitType) => {
            const workPermitDetails = workDetails.filter((detail: WorkDetailType) => detail.id === workPermit.workDetailsId);
            workPermit.workDetail = workPermitDetails || null;
        }))
        response.data = workPermits as WorkPermitType[];
    } else {
        response.error = [...getWorkPermitResponse.error as string[], ...getWorkDetailsResponse.error as string[]];
    }
    response.success = !response.error;
    
    return response;
}