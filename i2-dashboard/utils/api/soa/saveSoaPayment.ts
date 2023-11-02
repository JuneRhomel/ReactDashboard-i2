import { saveSoaPaymentType } from "@/types/models";
import { ApiResponse, ErrorType } from "@/types/responseWrapper";
import chunkSplitBase64Encode from "@/utils/chunkSplitBase64Encode";

export default async function saveSoaPayment(formData: any) {
    let chunkedFileData: string | null = null;
    console.log('inside api');
    console.log(formData);
    const amount: number = formData.amount;
    const file: File | undefined = formData.file;
    const fileData = file && await processFile(file);
    console.log(fileData);

    const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const module = 'gatepass';
    const errors: ErrorType[] = [];
    const response: ApiResponse<saveSoaPaymentType> = {
        success: false,
        data: {
            id: undefined,
        },
        error: undefined,
    }

    const gatepassDataBody: ParamSaveGatepassType = {
        date: currentDate,
        module: module,
        table: 'gatepass',
        name_id: nameId,
        unit_id: unitId,
        gp_type: formData.gatepassType as string,
        gp_date: formData.forDate as string,
        gp_time: formData.time as string,
        contact_no: formData.contactNumber as string,
    }

    const personnelDataBody: ParamGatepassPersonnelType = {
        gatepass_id: '',
        module: module,
        table: 'gatepass_personnel',
        company_name: personnel?.courier as string,
        personnel_name: personnel?.courierName as string,
        personnel_no: personnel?.courierContact as string,
    }
    
    console.log("Submitting Gatepass Request...")
    const gatepassResponse = await postRequest(gatepassDataBody);
    const gatepassId = gatepassResponse.id;
    if (gatepassId) {
        console.log("Gatepass was saved");
        const itemIds: number[] = [];
        const processItemsPromise = (async () => {
            await Promise.all(items.map(async (item) => {
                console.log("Submitting save item request...")
                const itemDataBody = {
                    item_name: item.itemName as string,
                    item_qty: item.itemQuantity?.toString() as string,
                    description: item.itemDescription as string,
                    gatepass_id: gatepassId,
                    table: 'gatepass_items',
                    module: module,
                }
                const itemResponse = await postRequest(itemDataBody);
                itemResponse.id ? itemIds.push(itemResponse.id) : errors.push(getErrorObject(itemDataBody as ParamGatepassItemType, itemResponse));
                console.log(itemResponse.id ? "Item Saved" : "Item not saved");
            }))
        });

        personnelDataBody.gatepass_id = gatepassId

        const personnelResponsePromise = (async () => {
            console.log("Submitting Personnel save request");
            const personnelResponse = await postRequest(personnelDataBody);
            personnelResponse.id ? response.data ? response.data.personnelId = personnelResponse.id : null : errors.push(getErrorObject(personnelDataBody as ParamGatepassPersonnelType, personnelResponse));
            console.log(personnelResponse.id ? "personnel saved" : "personnel not saved");
        })
        await Promise.all([processItemsPromise(), personnelResponsePromise()]);
        response.data ? response.data.itemIds = itemIds : null;
    } else {
        errors.push(getErrorObject(gatepassDataBody as ParamSaveGatepassType, gatepassResponse));
    }
    response.success = errors.length == 0;
    response.errors = errors;
    const getGatepassParams = {
        accountcode: 'adminmailinatorcom',
        id: gatepassId,
    }
    const newGatepassResponse = await api.requests.getGatepasses(getGatepassParams)
    const newGatepass = typeof newGatepassResponse !== 'string' ? newGatepassResponse.pop() : undefined;
    response.data ? response.data.gatepass = newGatepass : null;
    
    console.log(response);
    return response;

}

const processFile = async (file: File) : Promise<string> => {
    let chunkedFileData = '';
    const reader = new FileReader();

    // Create a promise that resolves when the file is read
    const fileReadPromise = new Promise<void>((resolve, reject) => {
        reader.onload = (e) => {
            const base64Data = (e.target?.result as string | undefined)?.split(',')[1]; // Extract the base64-encoded part
            chunkedFileData = chunkSplitBase64Encode(base64Data || ''); // Split into chunks
            console.log(chunkedFileData); // Log within the callback to see the updated value
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
