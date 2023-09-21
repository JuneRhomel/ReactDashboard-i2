/**
* This wrapper type is to define an APIResponse
*
*/
export type ApiResponse<T> = {
    success?: number;
    description?: string;
    data?: T;
    status?: number;
    message?: string;
}