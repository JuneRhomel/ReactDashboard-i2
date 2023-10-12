import getCookieString from "@/utils/getCookieString";
import { NextApiRequest, NextApiResponse } from "next";

const logout = (req: NextApiRequest, res: NextApiResponse) => {
    const token = req.cookies.token;
    if (token) {
        const logoutCookie: string = getCookieString(token, -1);
        res.status(200)
            .setHeader("Set-Cookie", logoutCookie)
            .json({message: "Logout successful"});
    }
    // Thinking about adding error handling here. But really if the user is not logged in then they cannot be logged out.
    return;
}

export default logout;