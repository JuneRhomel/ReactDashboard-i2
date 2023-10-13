export type ParamGetSoaType = {
    accountcode: string,
    userId: number,
    limit?: number,
}

export type ParamGetSoaDetailsType = {
    accountcode: string,
    soaId: number,
    limit?: number,
}

export interface ParamGetServiceRequestType {
    accountcode: string,
    userId: number,
    limit?: number,
}