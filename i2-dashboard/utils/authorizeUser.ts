import jwt, { Secret } from "jsonwebtoken";
const jwtSecret: Secret = process.env.JWT_SECRET as Secret;

const authorizeUser = (token : string) => {
    let user = {}
    try {
        user = jwt.verify(token, jwtSecret);
        user.isAuthorized = true;
    } catch (error){
        if (error.message === 'jwt expired'){
            user = jwt.decode(token);
            user.isAuthorized = false;
        }
        return;
    }
    delete user?.exp;
    delete user?.iat;
    console.log(user)
    return user;
}

export default authorizeUser;