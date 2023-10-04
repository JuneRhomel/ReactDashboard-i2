import { User, UserTokenPayload } from "@/types/models";
import jwt, { Secret } from "jsonwebtoken";
const jwtSecret: Secret = process.env.JWT_SECRET as Secret;

const authorizeUser = (token : string) => {
    let user : UserTokenPayload;
    try {
        user = jwt.verify(token, jwtSecret) as UserTokenPayload;
        user.isAuthorized = true;
    } catch (error: any){
        //Might not even need this if block here since if the jwt was not verified, we do not return a true isAuthorized property
        //We could send an error message to show the user, saying that their token is either invalid or expired.
        if (error.message === 'jwt expired'){
            user = jwt.decode(token) as UserTokenPayload;
            user.isAuthorized = false;
        }
        return { redirect: {destination: '/?error=accessDenied', permanent: false} }
    }
    
    delete user.iat;
    delete user.exp;
    return { props: { user } };
}

export default authorizeUser;