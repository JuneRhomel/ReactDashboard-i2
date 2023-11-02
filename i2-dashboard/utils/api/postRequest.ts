
export default async function postRequest(body: any, url: string) {
    const method = 'POST';
    try {
        const response: Response = await fetch(url, {
            method: method,
            body: JSON.stringify(body),
            referrerPolicy: "unsafe-url"
        });
        if (!response.ok) {
            //Need to fix this error handling here so that I can pass the error message to the screen instead of just here
            throw new Error(`HTTP error! Status: ${response.status}, Response: ${JSON.stringify(await response.json())}`);
        }
        return await response.json();
        
    } catch (error: any) {
        return error.message ? error.message : "Something went wrong";
    }
}