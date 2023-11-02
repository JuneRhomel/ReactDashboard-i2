import { FileDataType, ParamSaveSoaPayment } from "@/types/apiRequestParams";
import { SaveSoaPaymentFormData, SaveSoaPaymentType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";
import chunkSplitBase64Encode from "@/utils/chunkSplitBase64Encode";
import getDateString from "@/utils/getDateString";
import postRequest from "../postRequest";
import getErrorObject from "../getErrorObject";

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

const processFile = async (file: File) : Promise<string> => {
    let chunkedFileData = '';
    const reader = new FileReader();

    // Create a promise that resolves when the file is read
    const fileReadPromise = new Promise<void>((resolve, reject) => {
        reader.onload = (e) => {
            const base64Data = (e.target?.result as string | undefined)?.split(',')[1]; // Extract the base64-encoded part
            chunkedFileData = chunkSplitBase64Encode(base64Data || ''); // Split into chunks
            resolve();
        };
        reader.onerror = (e) => {
            reject(e);
        };
    });

    reader.readAsDataURL(file); // Read the file as a data URL (base64-encoded)

    try {
        await fileReadPromise; // Wait for the file to be read
    } catch (error) {
        console.error("Error reading the file:", error);
    }

    return chunkedFileData;
}
