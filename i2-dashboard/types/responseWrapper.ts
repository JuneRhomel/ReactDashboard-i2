import { SoaDetailsType, SoaType } from "./models";

/**
* This wrapper type is to define an APIResponse
*
*/
export type ApiResponse<T = never> = {
    success?: number | boolean;
    description?: string;
    id?: string;
    data?: T | null;
    status?: number;
    message?: string;
    error?: ErrorType[] | string[];
}

export type ErrorType = {
    message: string,
    data: any,
}

export type GetSoaResponse = SoaType[] | ApiResponse;

export type GetSoaDetailsResponse = SoaDetailsType[] | ApiResponse;
