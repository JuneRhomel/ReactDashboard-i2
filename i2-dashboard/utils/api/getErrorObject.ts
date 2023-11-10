import { ParamGatepassItemType, ParamGatepassPersonnelType, ParamGetServiceRequestType, ParamSaveGatepassType, ParamSaveGuestListType, ParamSaveSoaPayment, ParamSaveVisitorPassType, ParamSaveWorkDetailsType, ParamSaveWorkMaterialsType, ParamSaveWorkPermitType, ParamSaveWorkPersonnelType, ParamSaveWorkToolsType } from "@/types/apiRequestParams";

type RequestBodyType = ParamGatepassItemType | ParamSaveGatepassType | ParamGatepassPersonnelType | ParamSaveVisitorPassType | ParamSaveGuestListType | ParamSaveSoaPayment | ParamGetServiceRequestType | ParamSaveWorkDetailsType | ParamSaveWorkMaterialsType | ParamSaveWorkPermitType | ParamSaveWorkPersonnelType | ParamSaveWorkToolsType

export default function getErrorObject(requestBody: RequestBodyType, response: string) {
    const newError = {
        message: response,
        data: requestBody,
    }
    return newError;
}