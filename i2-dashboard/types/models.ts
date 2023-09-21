import { z } from "zod";

export type AuthenticatedUser = {
    token: string;
    tenantName: string;
    tenantId: number;
    email: string;
    mobile: number;
    db: string;
    tmp?: null | string;
}

export const AuthenticatedUserSchema = z.object({
    token: z.string(),
    tenantName: z.string(),
    tenantId: z.number(),
    email: z.string(),
    mobile: z.number(),
    db: z.string(),
    tmp: z.string().nullable().optional()
});

export type LoginSchema = {
    email: string;
    password: string;
    accountcode: string;
}