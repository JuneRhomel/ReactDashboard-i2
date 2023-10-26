import { NextApiRequest, NextApiResponse } from "next";
import copyHeaders from "@/utils/copyHeaders";
import { ApiResponse } from "@/types/responseWrapper";
import { GatepassTypeType } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";

const baseURL: string = "http://apii2-sandbox.inventiproptech.com";
const url: string = `${baseURL}/tenant/save`;
const accountCode = process.env.TEST_ACCOUNT_CODE;
// const accountCode = 'fee';

const saveGatepass = async (req: NextApiRequest, res: NextApiResponse) => {
    const jwt = req.cookies.token as string;
    const user = authorizeUser(jwt);
    const token = `${user?.token}:tenant`;
    const jsonBody = JSON.parse(req.body);
    const requestBody = jsonBody.gatepassData || jsonBody.personnelData || jsonBody.itemData;
    const body = JSON.stringify({...requestBody, accountcode: accountCode});
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };
    try {
        const response = await fetch(url, {
            method: req.method,
            body: body,
            headers: headers,
            referrerPolicy: "unsafe-url"
        })
        const jsonResponse: ApiResponse = await response.json()
        if (jsonResponse.success) {
            const payload = jsonResponse;
            res.status(200)
                .json(payload);
        } else {
            const errorMessage = jsonResponse.status ? jsonResponse.message : jsonResponse.description;
            const error = jsonResponse.status ? 'Unauthorized' : 'Bad Request';
            const errorStatus = jsonResponse.status || 400;
            const errorResponse = {
                error: error,
                message: errorMessage
            }
            res.status(errorStatus)
                .json(errorResponse);
        }
    } catch (error){
        console.error(error)
        res.status(500).json({ error: "Internal Server Error" });
    }
    return;
}

export default saveGatepass;