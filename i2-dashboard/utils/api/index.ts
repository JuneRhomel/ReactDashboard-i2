// This will be our api object that can make requests to the backend server
import { authenticate } from "./user/authenticate";
import { getSoa } from "./soa/getSoa";
import { getSoaDetails } from "./soa/getSoaDetails";
import { logout } from "./user/logout";

/**
* This object contains all the API functions for the client to make user related requests
*/
const user = {
    authenticate: authenticate,
    logout: logout,
}

const soa = {
    getSoa: getSoa,
    getSoaDetails: getSoaDetails,
}

const api = {
    user,
    soa
}

export default api;