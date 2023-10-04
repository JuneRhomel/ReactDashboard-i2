import { AuthenticatedUser, AuthenticatedUserSchema, LoginSchema } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import { json } from "stream/consumers";

const userToken: string = "thisIsASampleUserToken"
const baseURL: string = "http://apii2-sandbox.inventiproptech.com";
const API_ID: string = 'UdAgg7J2Htbp5WECsm42LnUnXxLG5NwM';
const API_SECRET: string = '8vYW4XyXEsTUsxg8LvKzWcyB54BSFDa2'

/** 
* Authenticates the user, returning an api response and message along with the user's data and authentication token.
* @summary If no parameters are provided, this function wil use the user's authentication cookie. If parameters are passed, this will use the user's email and password to authenticate.
* @param {LoginSchema} params - Optional. This is a json object that has the login form data
* @return {Promise<ApiResponse<AuthenticatedUser>>} Returns a promise of an API response of type AuthenticatedUser.
*/
export async function authenticate(params?: LoginSchema): Promise<Response>{//<ApiResponse<AuthenticatedUser>> {
    // const url: string = `${baseURL}/tenant/authenticate`;
    const url: string = '/api/user/authenticate';
    const authorizationToken: string = btoa(`${API_ID}:${API_SECRET}`); //base64 encode the API secret and key
    const token: string = params ? authorizationToken : userToken;
    const method: string = 'POST';
    const body: string | null = params ? JSON.stringify(params) : null;
    const headers = {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
    };

    try {
        const response = await fetch(url, {
          method: method,
          headers: headers,
          body: body,
          referrerPolicy: "unsafe-url"
        });
        if (!response.ok) {
          //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${response.status}, Response: ${JSON.stringify(await response.json())}`);
          }
          return response;
        } catch (error: any) {
        return error.message ? error.message : "Something went wrong";
    }
}