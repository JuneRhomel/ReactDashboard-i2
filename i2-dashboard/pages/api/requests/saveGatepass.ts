import { NextApiRequest, NextApiResponse } from "next";
import copyHeaders from "@/utils/copyHeaders";
import { ApiResponse } from "@/types/responseWrapper";
import { GatepassTypeType } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";

const baseURL: string = "http://apii2-sandbox.inventiproptech.com";
const url: string = `${baseURL}/tenant/save`;
const accountCode = process.env.TEST_ACCOUNT_CODE;

const saveGatepass = async (req: NextApiRequest, res: NextApiResponse) => {
    const jwt = req.cookies.token as string;
    const user = authorizeUser(jwt);
    const token = `${user?.token}:tenant`;
    const reqBody = JSON.parse(req.body);
    const gatepassBody = {...reqBody.gatepassData, accountcode: accountCode};
    const body = JSON.stringify(gatepassBody);
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
        const jsonResponse: ApiResponse<GatepassTypeType[]> = await response.json()
        console.log(jsonResponse)
        if (Array.isArray(jsonResponse)) {
            const payload= jsonResponse as GatepassTypeType[];
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

export default saveGatepass;