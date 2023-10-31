import { UserType, UserTokenPayload } from "@/types/models";
import jwt, { Secret } from "jsonwebtoken";
import mapObject from "./parseObject";
const jwtSecret: Secret = process.env.JWT_SECRET as Secret;

const authorizeUser = (token : string) => {
    try {
        const tokenPayload = jwt.verify(token, jwtSecret) as UserTokenPayload;
        tokenPayload.isAuthorized = true;
        const user: UserType = mapObject(tokenPayload) as UserType;
        return user;
    } catch (error: any){
        //Might not even need this if block here since if the jwt was not verified, we do not return a true isAuthorized property
        //We could send an error message to show the user, saying that their token is either invalid or expired.
        if (error.message === 'jwt expired'){
            const tokenPayload = jwt.decode(token) as UserTokenPayload;
            tokenPayload.isAuthorized = false;
        }
        return null;
    }
}

export default authorizeUser;