import { Soa } from "./models";

/**
* This wrapper type is to define an APIResponse
*
*/
export type ApiResponse<T = never> = {
    success?: number;
    description?: string;
    data?: T;
    status?: number;
    message?: string;
}

export type GetSoaResponse = Soa[] | ApiResponse;
