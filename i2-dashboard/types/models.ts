import { z } from "zod";

export type User = {
    token: string;
    tenantName: string;
    tenantId: number;
    email: string;
    mobile: number;
    db: string;
    tmp?: null | string;
    isAuthorized?: boolean
}

export type UserTokenPayload = User & {
    iat?: number;
    exp?: number;
}

export type LoginSchema = {
    email: string;
    password: string;
    accountcode: string;
}