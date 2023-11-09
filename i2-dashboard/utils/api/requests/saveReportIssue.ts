import { ParamSaveReportIssueType } from "@/types/apiRequestParams";
import { ReportIssueFormDataType, ServiceIssueType } from "@/types/models";
import api from "..";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";
import postRequest from "../postRequest";
import processFile from "@/utils/processFile";

const url: string = '/api/requests/saveServiceRequest/?type=issue';
const method: string = 'POST';
const nameId = '1';
const unitId = '5';
const token = "c8c69a475a9715c2f2c6194bc1974fae:tenant";

/** 
* Saves the user's issue report. 
* @param {ReportIssueFormDataType} formData
* @return {Promise<ApiResponse<ServiceIssueType>>} Returns a promise of a Response object.
*/
export default async function saveReportIssue(formData: ReportIssueFormDataType, user=null): Promise<ApiResponse<ServiceIssueType>> {
    const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const module = 'reportissue';
    const error: ErrorType[] = [];
    const response: ApiResponse<ServiceIssueType> = {
        success: false,
        data: undefined,
        error: undefined,
    }
    const file: File | undefined = formData.file;
    const chunkedFileData = file ? await processFile(file) : undefined;
    
    if (chunkedFileData) {
        const fileData = {
            filename: file?.name as string,
            data: chunkedFileData,
        }

        const body: ParamSaveReportIssueType = {
            date: currentDate,
            module: module,
            table: 'report_issue',
            name_id: nameId,
            unit_id: unitId,
            contact_no: formData.contactNumber as string,
            status_id: '1',
            created_by: nameId,
            description: formData.description as string,
            issue_id: formData.issueCategory as string,
            attachments: [fileData],
        };
        
        console.log("Submitting Report Issue Request...")
        const issueResponse = await postRequest(body, url);
        const issueId = issueResponse.id;
        if (issueId) {
            console.log("Report Issue was saved");
            const getReportIssueParams = {
                accountcode: 'adminmailinatorcom',
                id: issueId,
            }
            const newIssueResponse = await api.requests.getIssues(getReportIssueParams);
            console.log({newIssueResponse})
            response.data = newIssueResponse.success ? newIssueResponse.data?.pop() : undefined;
        } else {
            error.push(issueResponse);
        }
    } else {
        const newError: ErrorType = {
            message: "Could not process the file. Please check your selected file to upload and try again.",
            data: undefined
        }
        error.push(newError);
    }
    
    response.success = error.length == 0;
    response.error = error;
    
    return response;
}