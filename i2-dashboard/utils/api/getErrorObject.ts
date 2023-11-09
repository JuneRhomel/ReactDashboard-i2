import { ParamGatepassItemType, ParamGatepassPersonnelType, ParamGetServiceRequestType, ParamSaveGatepassType, ParamSaveGuestListType, ParamSaveSoaPayment, ParamSaveVisitorPassType } from "@/types/apiRequestParams";

type RequestBodyType = ParamGatepassItemType | ParamSaveGatepassType | ParamGatepassPersonnelType | ParamSaveVisitorPassType | ParamSaveGuestListType | ParamSaveSoaPayment | ParamGetServiceRequestType;

export default function getErrorObject(requestBody: RequestBodyType, response: string) {
    const newError = {
        message: response,
        data: requestBody,
    }
    return newError;
}