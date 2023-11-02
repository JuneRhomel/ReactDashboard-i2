import { ParamGatepassItemType, ParamGatepassPersonnelType, ParamSaveGatepassType, ParamSaveGuestListType, ParamSaveSoaPayment, ParamSaveVisitorPassType } from "@/types/apiRequestParams";

type RequestBodyType = ParamGatepassItemType | ParamSaveGatepassType | ParamGatepassPersonnelType | ParamSaveVisitorPassType | ParamSaveGuestListType | ParamSaveSoaPayment

export default function getErrorObject(requestBody: RequestBodyType, response: string) {
    const newError = {
        message: response,
        data: requestBody,
    }
    return newError;
}