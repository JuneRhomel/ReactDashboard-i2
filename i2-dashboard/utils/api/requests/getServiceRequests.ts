import { ParamGetServiceRequestType } from "@/types/apiRequestParams";
import { GatepassType, ServiceIssueType, ServiceRequestDataType, ServiceRequestType, VisitorsPassType, WorkPermitType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";
import getErrorObject from "../getErrorObject";
import api from "..";
import parseObject from "@/utils/parseObject";

const userToken: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant"

/** 
* Fetches the all the user's service requests
* @param {ParamGetServiceRequestType} params - This is a json object that has accountCode, queryCondition, and resultLimit
* @return {Promise<ApiResponse<ServiceRequestType[]>>} Returns a promise of an API response with either ServiceRequest data or errors.
*/
export async function getServiceRequests(params: ParamGetServiceRequestType, token: string = "c8c69a475a9715c2f2c6194bc1974fae:tenant", context: any): Promise<ApiResponse<ServiceRequestType[]>>{
    const url: string = `${process.env.API_URL}/tenant/get-allsr`;
    const method: string = 'POST';
    const body = {
        accountcode: params.accountcode,
        condition: `name_id=${params.userId}`,
        limit: params.limit,
    };
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };

    const response: ApiResponse<ServiceRequestType[]> = {
        success: false,
        data: undefined,
        error: undefined,
    }
    const errors: (ErrorType | string)[] = [];
    try {
        const serviceRequestPromise = fetch(url, {
            method: method,
            headers: headers,
            body: JSON.stringify(body),
            referrerPolicy: "unsafe-url"
        });

        const serviceRequestDetailsBody = {...params, limit: 30};
        const gatepassPromise = api.requests.getGatepasses(serviceRequestDetailsBody, token, context);
        const workPermitPromise = api.requests.getWorkPermits(serviceRequestDetailsBody, token, context);
        const visitorPassPromise = api.requests.getVisitorPasses(serviceRequestDetailsBody, token, context);
        const serviceIssuePromise = api.requests.getIssues(serviceRequestDetailsBody, token, context);
        const [
          serviceRequestResponse,
          gatepassResponse,
          workPermitResponse,
          visitorPassResponse,
          serviceIssueResponse,
        ] = await Promise.all([
            serviceRequestPromise,
            gatepassPromise,
            workPermitPromise,
            visitorPassPromise,
            serviceIssuePromise
        ]);

        const serviceRequestResponseBody = await serviceRequestResponse.json();

        if (!serviceRequestResponse.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${serviceRequestResponse.status}, Response: ${JSON.stringify(serviceRequestResponseBody)}`);
        }
        if (serviceRequestResponseBody.success == 0) {
            throw new Error(`HTTP Error! Status: 400 Bad Request. Response: ${JSON.stringify(serviceRequestResponseBody.description)}`);
        }

        const responses = [gatepassResponse, workPermitResponse, visitorPassResponse, serviceIssueResponse];
        responses.forEach((apiResponse) => {
            if (!apiResponse.success) {
                const error = apiResponse.error as (ErrorType | string)[];
                error && errors.push(...error);
            }
        })
        if (errors.length == 0) {
            const serviceRequests = parseObject(serviceRequestResponseBody) as ServiceRequestType[];
            const gatepasses = parseObject(responses?.shift()?.data as GatepassType[]) as GatepassType[];
            const workPermits = parseObject(responses?.shift()?.data as WorkPermitType[]) as WorkPermitType[];
            const visitorPasses = parseObject(responses?.shift()?.data as VisitorsPassType[]) as VisitorsPassType[];
            const serviceIssues = parseObject(responses?.shift()?.data as ServiceIssueType[]) as ServiceIssueType[];
            serviceRequests.sort((a, b) => {
              const aDate: Date = new Date(a.dateUpload);
              const bDate: Date = new Date(b.dateUpload);
              return bDate.getTime() - aDate.getTime();
            });
            const requestDetails = new Map<string, ServiceRequestDataType[]>([
              ['Gate Pass', gatepasses],
              ['Work Permit', workPermits],
              ['Visitor Pass', visitorPasses],
              ['Report Issue', serviceIssues]
            ]);
            serviceRequests?.forEach((request: ServiceRequestType) => {
              const type = request.type;
              const details = requestDetails.get(type);
              const requestData = details?.find((detail: ServiceRequestDataType) => detail?.id === request.id);
              request.data = requestData || null;
            })
            response.data = serviceRequests as ServiceRequestType[];       
        }
    } catch (error: any) {
        const errorObject: ErrorType = getErrorObject(body, error.message);
        errors.push(errorObject);
    }
    response.error = errors;
    response.success = response.error.length == 0;
    return response;
}