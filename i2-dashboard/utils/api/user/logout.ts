const userToken: string = "thisIsASampleUserToken"
const baseURL: string = "http://apii2-sandbox.inventiproptech.com";
const API_ID: string = 'UdAgg7J2Htbp5WECsm42LnUnXxLG5NwM';
const API_SECRET: string = '8vYW4XyXEsTUsxg8LvKzWcyB54BSFDa2'

/** 
* Logs the user out, returning an api response and a success message.
* @summary If no parameters are provided, this function wil use the user's authentication cookie. If parameters are passed, this will use the user's email and password to authenticate.
* @return {Promise<Response>} Returns a promise of a Response Object.
*/
export async function logout(): Promise<Response>{
    const url: string = '/api/user/logout';
    const method: string = 'POST';
    const headers = {
        'Content-Type': 'application/json',
    };

    try {
        const response: Response = await fetch(url, {
            method: method,
            headers: headers,
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