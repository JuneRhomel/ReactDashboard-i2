// This will be our api object that can make requests to the backend server
import { authenticate } from "./user/authenticate";
import { getSoa } from "./soa/getSoa";

/**
* This object contains all the API functions for the client to make user related requests
*/
const user = {
    authenticate: authenticate,
}

const soa = {
    getSoa: getSoa,
}

const api = {
    user,
    soa
}

export default api;