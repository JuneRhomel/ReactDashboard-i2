import { AuthenticatedUser, LoginSchema } from "@/types/models";
import { ApiResponse } from "@/types/responseWrapper";
import { env } from "process";

const userToken: string = "thisIsASampleUserToken"

/** 
* Authenticates the user, returning an api response and message along with the user's data and authentication token. 
* @summary If no parameters are provided, this function wil use the user's authentication cookie. If parameters are passed, this will use the user's email and password to authenticate.
* @param {LoginSchema} parameterNameHere - Brief description of the parameter here. Note: For other notations of data types, please refer to JSDocs: DataTypes command.
* @return {Promise<ApiResponse<AuthenticatedUser>>} Brief description of the returning value here.
*/
export async function authenticate(params?: LoginSchema): Promise<ApiResponse<AuthenticatedUser>> {
    const url: string = `${env.REACT_APP_API_URL}/tenant/authenticate`;
    const authorizationToken: string = btoa(`${env.REACT_APP_API_ID}:${env.REACT_APP_API_KEY}`); //base64 encode the API secret and key
    const token: string = params ? authorizationToken : userToken;
    const method: string = params ? 'POST' : 'GET';
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
      });
  
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response;
    } catch (error: any) {
          return error.message ? error.message : "Something went wrong";
    }
}