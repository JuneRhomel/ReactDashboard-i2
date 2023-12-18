import { UserType } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import { NextApiRequest, NextApiResponse } from "next";
import jwt, { Secret } from 'jsonwebtoken';
import copyHeaders from "@/utils/copyHeaders";
import getCookieString from "@/utils/getCookieString";
import parseObject from "@/utils/parseObject";
import axios from "axios";
const baseURL: string = "https://apii2-sandbox.inventiproptech.com";
const url: string = `${baseURL}/tenant/authenticate`;
const jwtSecret: Secret = process.env.JWT_SECRET as Secret;


const authenticate = async (req: NextApiRequest, res: NextApiResponse) => {
    try {
        const requestBody = JSON.stringify(req.body);
        const requestHeaders: HeadersInit = copyHeaders(req);

        const authenticationResponse = await axios.post(url, req.body, {
            headers: requestHeaders,
        });
        const jsonResponse: ApiResponse<UserType> = authenticationResponse.data;
        if (jsonResponse.success) {
           
            const user: UserType = jsonResponse?.data as UserType;
            const getUserRequestBody = {
                accountcode: req.body.accountcode,
                view: 'users',
            };
            requestHeaders.Authorization = `Bearer ${user.token}:tenant`;

            const getUserResponse = await axios.post(`${baseURL}/tenant/get-user`, getUserRequestBody, {
                headers: requestHeaders,
                timeout: 10000,
            });

            if (getUserResponse.status === 200) {
                const responseBody = getUserResponse.data;
                const rawUser = parseObject(responseBody) as any;

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
                };

                const token: string = jwt.sign(payload, jwtSecret, { expiresIn: '1d' });
                const cookie: string = getCookieString(token);
                res.status(200)
                    .setHeader("Set-Cookie", cookie)
                    .json(payload);
            }
        } else {
            const errorMessage = jsonResponse.status ? "Invalid account code" : "Invalid username and/or password";
            const error = {
                "error": "Unauthorized",
                "message": errorMessage
            };

            res.status(401)
                .setHeader("Set-Cookie", getCookieString("Invalid", -1))
                .json(error);
        }
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: "Internal Server Error" });
    }
    return;
}

export default authenticate;