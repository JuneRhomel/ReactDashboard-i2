import { UserType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import { NextApiRequest, NextApiResponse } from "next";
import jwt, { Secret } from 'jsonwebtoken';
import copyHeaders from "@/utils/copyHeaders";
import getCookieString from "@/utils/getCookieString";
import parseObject from "@/utils/parseObject";

const baseURL: string = "https://apii2-sandbox.inventiproptech.com";
const url: string = `${baseURL}/tenant/authenticate`;
const jwtSecret : Secret = process.env.JWT_SECRET as Secret;

const authenticate = async (req: NextApiRequest, res: NextApiResponse) => {
    const body = JSON.stringify(req.body);
    const headers: HeadersInit = copyHeaders(req);

    try {
        //authenticate the user
        const response = await fetch(url, {
            method: req.method,
            body: body,
            headers: headers,
            referrerPolicy: "unsafe-url"
        })
        const jsonResponse: ApiResponse<UserType> = await response.json()
        if (jsonResponse.success) {
            // Create a jwt with the user info
            const user: UserType = jsonResponse?.data as UserType;
            const body = {
                accountcode: req.body.accountcode,
                view: 'users',
            }
            headers.Authorization = `Bearer ${user.token}:tenant`;
            //fetch the user using their authorization token
            const response = await fetch(`${baseURL}/tenant/get-user`, {
                method: req.method,
                body: JSON.stringify(body),
                headers: headers,
                referrerPolicy: 'unsafe-url',
            })
            if (response.ok) {
                const responseBody = await response.json();
                const rawUser = parseObject(responseBody) as any;
                //create this new User object with only relevant fields needed
                const payload: UserType = {
                    id: rawUser.id,
                    token: user.token,
                    firstName: rawUser.firstName,
                    lastName: rawUser.lastName,
                    companyName: rawUser.companyName,
                    type: rawUser.type,
                    address: rawUser.address,
                    contactNumber: rawUser.contactNo,
                    email: rawUser.email,
                    unitId: rawUser.unitId,
                    unitName: rawUser.unitName,
                    status: rawUser.status,
                    db: user.db,
                    tmp: user.tmp,
                    isAuthorized: true,
                }
                const token: string = jwt.sign(payload, jwtSecret, {expiresIn: '1d'})
                const cookie: string = getCookieString(token);
                //respond with 200 status and with the jwt set as a cookie
                res.status(200)
                    .setHeader("Set-Cookie", cookie)
                    .json(payload);
            }
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