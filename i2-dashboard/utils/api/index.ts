// This will be our api object that can make requests to the backend server
import { authenticate } from "./user/authenticate";
import { getSoa } from "./soa/getSoa";
import { getSoaDetails } from "./soa/getSoaDetails";
import { logout } from "./user/logout";
import { getServiceRequests } from "./requests/getServiceRequests";
import { getServiceRequestDetails } from "./requests/getServiceRequestDetails";
import { getGatePasses } from "./requests/getGatePasses";

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

const requests = {
    getServiceRequests: getServiceRequests,
    getServiceRequestDetails: getServiceRequestDetails,
    getGatePasses: getGatePasses,
}

const api = {
    user,
    soa,
    requests,
}

export default api;