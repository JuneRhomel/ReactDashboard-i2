import { ParamSaveGuestListType, ParamSaveVisitorPassType, ParamSaveWorkDetailsType, ParamSaveWorkMaterialsType, ParamSaveWorkPermitType, ParamSaveWorkPersonnelType, ParamSaveWorkToolsType } from "@/types/apiRequestParams";
import { CreateVisitorPassFormDataType, CreateWorkPermitFormType, GuestDataType, SaveVisitorPassDataType, SaveWorkPermitDataType, UserType, WorkDetailsType, WorkMaterialsType, WorkPersonnelType, WorkToolsType } from "@/types/models";
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
* Saves the user's Visitor Pass request.
* @param {CreateVisitorPassFormDataType} formData
* @return {Promise<ApiResponse<SaveWorkPermitDataType>>} Returns a promise of a SaveServiceRequestResponse where the data is SaveVisitorPassData object.
*/
export default async function saveWorkPermit(formData: CreateWorkPermitFormType, user: UserType): Promise<ApiResponse<SaveWorkPermitDataType>> {
    const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const module = 'workpermit';
    const workDetailsData = formData.workDetails as WorkDetailsType;
    const workToolsData = formData.workTools as WorkToolsType[];
    const workPersonnelData = formData.workPersonnel as WorkPersonnelType[];
    const workMaterialsData = formData.workMaterials as WorkMaterialsType[];
    const errors: ErrorType[] = [];
    const workToolIds: number[] = [];
    const workMaterialIds: number[] = [];
    const workPersonnelIds: number[] = [];
    let thisWorkPermitId = 0;
    const response: ApiResponse<SaveWorkPermitDataType> = {
        success: false,
        data: {
            workPermit: undefined,
            workDetailsId: undefined,
            toolsIds: [],
            personnelIds: [],
            materialIds: [],
        },
        error: undefined,
    }
    const workDetailsBody: ParamSaveWorkDetailsType = {
        module: module,
        table: 'work_details',
        name_contractor: workDetailsData.contractorName as string,
        scope_work: workDetailsData.scopeOfWork as string,
        person_charge: workDetailsData.personInCharge as string,
        contact_number: workDetailsData.contractorContact as string,
    }

    console.log("Submitting Work Details Request...");
    const workDetailsResponse = await postRequest(workDetailsBody, url);
    const workDetailId = workDetailsResponse.id;
    if (workDetailId) {
        console.log("Work Detail was saved");
        (response.data as SaveWorkPermitDataType).workDetailsId = workDetailId;
        const workPermitBody: ParamSaveWorkPermitType = {
            date: currentDate,
            module: module,
            table: "workpermit",
            name_id: user.id.toString(),
            unit_id: user.unitId.toString(),
            work_details_id: workDetailId,
            workpermitcategory_id: formData.workPermitCategory as string,
            start_date: formData.startDate as string,
            end_date: formData.endDate as string,
            contact_no: formData.contactNumber as string,
        }
        console.log("Saving Work Permit");
        const workPermitResponse = await postRequest(workPermitBody, url);
        const workPermitId = workPermitResponse.id;
        if (workPermitId) {
            console.log("Work Permit was saved");
            thisWorkPermitId = workPermitId;

            const workToolsPromise = Promise.all(workToolsData.map(async (workTool) => {
                console.log("Submitting save work tool request");
                const workToolBody: ParamSaveWorkToolsType = {
                    module: "workpermit",
                    table: "work_tools",
                    workpermit_id: workPermitId,
                    tools_name: workTool.toolName as string,
                    tools_qty: workTool.toolQuantity as string,
                    tools_desc: workTool.toolDescription as string,
                };
                const workToolResponse = await postRequest(workToolBody, url);
                workToolResponse.id ? workToolIds.push(workToolResponse.id) : errors.push(getErrorObject(workToolBody as ParamSaveWorkToolsType, workToolResponse));
                console.log(workToolResponse.id ? "Work Tool was Saved" : "Work Tool not saved");
            }))

            const workMaterialsPromise = Promise.all(workMaterialsData.map(async (workMaterial) => {
                console.log("Submitting Work Materials Save request");
                const workMaterialBody: ParamSaveWorkMaterialsType = {
                    module: module,
                    table: "work_materials",
                    workpermit_id: workPermitId,
                    materials_name: workMaterial.materialName as string,
                    quantity_materials: workMaterial.materialQuantity as string,
                    description_materials: workMaterial.materialDescription as string,
                }
                const workMaterialResponse = await postRequest(workMaterialBody, url);
                workMaterialResponse.id ? workMaterialIds.push(workMaterialResponse.id) : errors.push(getErrorObject(workMaterialBody as ParamSaveWorkMaterialsType, workMaterialResponse));
                console.log(workMaterialResponse.id ? "Work materials was saved" : "Work material not saved");
            }))

            const workPersonnelPromise = Promise.all(workPersonnelData.map(async (workPersonnel) => {
                console.log("Submitting work personnel save request");
                const workPersonnelBody: ParamSaveWorkPersonnelType = {
                    module: "workpermit",
                    table: "workers",
                    workpermit_id: workPermitId,
                    personnel_name: workPersonnel.personnelName as string,
                    personnel_description: workPersonnel.personnelDescription as string,
                }
                const workPersonnelResponse = await postRequest(workPersonnelBody, url);
                workPersonnelResponse.id ? workPersonnelIds.push(workPersonnelResponse.id) : errors.push(getErrorObject(workPersonnelBody as ParamSaveWorkPersonnelType, workPersonnelResponse));
                console.log(workPersonnelResponse.id ? "Work personnel was saved" : "Work personnel not saved");
            }))

            await Promise.all([workToolsPromise, workMaterialsPromise, workPersonnelPromise]);
        } else {
            errors.push(getErrorObject(workPermitBody as ParamSaveWorkPermitType, workPermitResponse));
        }

        (response.data as SaveWorkPermitDataType).workDetailsId = workDetailId;
    } else {
        errors.push(getErrorObject(workDetailsBody as ParamSaveWorkDetailsType, workDetailsResponse));
    }
    response.success = errors.length == 0;
    response.error = errors;
    const getWorkPermitParams = {
        accountcode: 'adminmailinatorcom',
        id: thisWorkPermitId,
    }
    const newWorkPermitResponse = await api.requests.getWorkPermits(getWorkPermitParams);
    const newWorkPermit = newWorkPermitResponse.success ? newWorkPermitResponse.data?.pop() : undefined;
    (response.data as SaveWorkPermitDataType).workPermit = newWorkPermit;
    (response.data as SaveWorkPermitDataType).toolsIds = workToolIds;
    (response.data as SaveWorkPermitDataType).materialIds = workMaterialIds;
    (response.data as SaveWorkPermitDataType).personnelIds = workPersonnelIds;

    
    console.log(response);
    return response;
}