import { NextApiRequest, NextApiResponse } from "next";
import copyHeaders from "@/utils/copyHeaders";
import { GetSoaDetailsResponse } from "@/types/responseWrapper";

const getSoaDetails = async (req: NextApiRequest, res: NextApiResponse) => {
    const url: string = `${process.env.API_URL}/tenant/get-list`;
    const body = JSON.stringify(req.body);
    const headers: HeadersInit = copyHeaders(req);
    try {
        const response = await fetch(url, {
            method: req.method,
            body: body,
            headers: headers,
            referrerPolicy: "unsafe-url"
        })

        const jsonResponse: GetSoaDetailsResponse = await response.json()

        if ('message' in jsonResponse) {
            const error = {
                "error": "Unauthorized",
                "message": jsonResponse.message,
            }
            res.status(401).json(error);
        } else if ('description' in jsonResponse) {
            const error = {
                "error": "Not Found",
                "message": jsonResponse.description
            }
            res.status(404).json(error);
        } else {
            res.status(200)
                .json(jsonResponse);
        }

    } catch (error){
        console.error(error)
        res.status(500).json({ error: "Internal Server Error" });
    }

    return;
}

export default getSoaDetails;