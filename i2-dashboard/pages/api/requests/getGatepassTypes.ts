import { NextApiRequest, NextApiResponse } from "next";
import copyHeaders from "@/utils/copyHeaders";
import { ApiResponse } from "@/types/responseWrapper";
import { SelectDataType } from "@/types/models";
import { fetch, setGlobalDispatcher, Agent } from 'undici'
setGlobalDispatcher(new Agent({ connect: { timeout: 90_000 } }) )
const baseURL: string = "http://apii2-sandbox.inventiproptech.com";
const url: string = `${baseURL}/tenant/get-listnew`;
const accountCode = process.env.TEST_ACCOUNT_CODE;

const getGatepassTypes = async (req: NextApiRequest, res: NextApiResponse) => {
    const body = JSON.stringify({...req.body, accountcode: accountCode});
    const headers: HeadersInit = copyHeaders(req);
    try {
        const response = await fetch(url, {
            method: req.method,
            body: body,
            headers: headers,
            referrerPolicy: "unsafe-url"
        })
        const jsonResponse: ApiResponse<SelectDataType[]> = await response.json()
        if (Array.isArray(jsonResponse)) {
            const payload= jsonResponse as SelectDataType[];
            res.status(200)
                .json(payload);
        } else {
            // If success==0 or response.success does not exist
            const errorMessage = jsonResponse.status ? "Invalid account code" : jsonResponse.description;
            const error = {
                "error": "Unauthorized",
                "message": errorMessage
            }
            res.status(401)
                .json(error);
        }

    } catch (error){
        console.error(error)
        res.status(500).json({ error: "Internal Server Error" });
    }
    return;
}

export default getGatepassTypes;