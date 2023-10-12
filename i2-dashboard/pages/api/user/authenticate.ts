import { UserType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import { NextApiRequest, NextApiResponse } from "next";
import jwt, { Secret } from 'jsonwebtoken';
import copyHeaders from "@/utils/copyHeaders";
import getCookieString from "@/utils/getCookieString";

const baseURL: string = "http://apii2-sandbox.inventiproptech.com";
const url: string = `${baseURL}/tenant/authenticate`;
const jwtSecret : Secret = process.env.JWT_SECRET as Secret;

const authenticate = async (req: NextApiRequest, res: NextApiResponse) => {
    const body = JSON.stringify(req.body);
    const headers: HeadersInit = copyHeaders(req);

    try {
        const response = await fetch(url, {
            method: req.method,
            body: body,
            headers: headers,
            referrerPolicy: "unsafe-url"
        })
        const jsonResponse: ApiResponse<UserType> = await response.json()
        if (jsonResponse.success) {
            // Create a jwt with the user info
            const payload: UserType = jsonResponse?.data as UserType;
            const token: string = jwt.sign(payload, jwtSecret, {expiresIn: '1d'})
            const cookie: string = getCookieString(token);
            res.status(200)
                .setHeader("Set-Cookie", cookie)
                .json(payload);
        } else {
            // If success==0 or response.success does not exist
            const errorMessage = jsonResponse.status ? "Invalid account code" : "Invalid username and/or password";
            const error = {
                "error": "Unauthorized",
                "message": errorMessage
            }
            res.status(401)
                .setHeader("Set-Cookie", getCookieString("Invalid", -1))
                .json(error);
        }

    } catch (error){
        console.error(error)
        res.status(500).json({ error: "Internal Server Error" });
    }
    return;
}



export default authenticate;