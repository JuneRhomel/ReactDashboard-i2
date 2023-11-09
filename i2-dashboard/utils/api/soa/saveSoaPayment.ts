import { FileDataType, ParamSaveSoaPayment } from "@/types/apiRequestParams";
import { SaveSoaPaymentFormData, SaveSoaPaymentType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";
import chunkSplitBase64Encode from "@/utils/chunkSplitBase64Encode";
import getDateString from "@/utils/getDateString";
import postRequest from "../postRequest";
import getErrorObject from "../getErrorObject";
import processFile from "@/utils/processFile";

const url = '/api/requests/saveServiceRequest';

export default async function saveSoaPayment(formData: SaveSoaPaymentFormData) {
    const file: File | undefined = formData.file;
    const today = new Date();
    const date = getDateString(today.getDate(), today.getMonth() + 1, today.getFullYear());
    const errors: ErrorType[] = [];
    const chunkedFileData = file ? await processFile(file) : undefined;
    
    const response: ApiResponse<SaveSoaPaymentType> = {
        success: false,
        data: {
            id: undefined,
        },
        error: undefined,
    }

    if (chunkedFileData) {
        const fileData: FileDataType = {
            filename: file.name,
            data: chunkedFileData,
        }    

        const body: ParamSaveSoaPayment = {
            module: 'soa_payment',
            table: 'soa_payment',
            soa_id: formData.soaId,
            payment_type: formData.paymentType,
            status: 'For Verification',
            particular: `SOA Payment - ${date}`,
            amount: formData.amount,
            attachments: [fileData],
        }
        
        console.log("Submitting Save Soa Payment Request...")
        const saveResponse = await postRequest(body, url);
        saveResponse.success ? (response.data as SaveSoaPaymentType).id = saveResponse.id : errors.push(getErrorObject(body, saveResponse));
        response.success = errors.length == 0;
        response.error = errors;
        
    } else {
        // need to hanlde the error
    }
    
    return response
}