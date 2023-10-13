import { z } from "zod";
import { ApiResponse } from "./responseWrapper";

export type UserType = {
    token: string;
    tenantName: string;
    tenantId: number;
    email: string;
    mobile: number;
    db: string;
    tmp?: null | string;
    isAuthorized: boolean
}

export type UserTokenPayload = {
    token: string;
    tenant_name: string;
    tenant_id: number;
    email: string;
    mobile: number;
    db: string;
    tmp?: null | string;
    iat?: number;
    exp?: number;
    isAuthorized?: boolean;
}

export type LoginSchema = {
    email: string;
    password: string;
    accountcode: string;
}

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

interface ChangeHistory {
    createdBy: string,
    createdOn: string,
    deletedBy: string,
    deletedOn: string
    encId: string,
}

export interface SoaType extends ChangeHistory{
    id: string,
    residentId: string,
    monthOf: string,
    yearOf: string,
    balance: string,
    chargeAmount: string,
    electricity: string,
    water: string,
    cusa: string,
    assoDues: string,
    currentCharges: string,
    amountDue: string,
    notes: string | null,
    status: string,
    posted: string,
    dueDate: string,
    residentName: string,
    companyName: string,
    unitName: string | null,
    locationName: string | null,
    floorArea: string | null | number,
    locationType: string | null,
}

export interface SoaDetailsType extends ChangeHistory{
    id: string,
    soaId: string,
    paymentType: string,
    particular: string,
    amount: string,
    checkNo: number | string | null,
    checkDate: string | null,
    checkAmount: number | string | null,
    status: string,
    transactionDate: string,
}
export interface RequestType extends ChangeHistory{
    id: string,
    date_upload: string,
    type: string,
    table: string,
}
export interface ListRequest extends ChangeHistory{
    title: string,
    img: string,
    link: string,
}