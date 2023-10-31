import { SoaDetailsType, SoaType } from "./models";

/**
* This wrapper type is to define an APIResponse
*
*/
export type ApiResponse<T = never> = {
    success?: number | boolean;
    description?: string;
    id?: string;
    data?: T;
    status?: number;
    message?: string;
    error?: string;
}

export type GetSoaResponse = SoaType[] | ApiResponse;

export type GetSoaDetailsResponse = SoaDetailsType[] | ApiResponse;
