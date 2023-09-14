export type AuthenticatedUser = {
    token: string,
    tenantName: string,
    tenantId: number,
    email: string,
    mobile: number,
    db: string,
    tmp?: null | string 
}

export type LoginSchema = {
    email: string,
    password: string
}