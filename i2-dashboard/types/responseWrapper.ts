import { SoaDetailsType, SoaType } from "./models";

/**
* This wrapper type is to define an APIResponse
*
*/
export type ApiResponse<T = never> = {
    success?: number;
    description?: string;
    id?: string;
    data?: T;
    status?: number;
    message?: string;
}

export type GetSoaResponse = SoaType[] | ApiResponse;

export type GetSoaDetailsResponse = SoaDetailsType[] | ApiResponse;
