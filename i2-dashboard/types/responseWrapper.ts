/**
* This wrapper type is to define an APIResponse
*
*/
export type ApiResponse<T> = {
    success?: boolean,
    description?: string,
    data?: T
    status?: number,
    message?: string,
}