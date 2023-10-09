import { User, UserTokenPayload } from "@/types/models";

const mapUser = (payload : UserTokenPayload) => {
    const user: User = {
        token: payload.token,
        tenantName: payload.tenant_name,
        tenantId: payload.tenant_id,
        email: payload.email,
        mobile: payload.mobile,
        db: payload.db,
        tmp: payload.tmp,
        isAuthorized: payload.isAuthorized as boolean,
    }
    return user;
}

export default mapUser;