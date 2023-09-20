// This will be our api object that can make requests to the backend server
import { authenticate } from "./user/authenticate";

/**
* This object contains all the API functions for the client to make user related requests
*/
const user = {
    authenticate: authenticate,
}

const api = {
    user,
}

export default api;