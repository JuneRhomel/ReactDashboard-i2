// This will be our api object that can make requests to the backend server
import { authenticate } from "./user/authenticate";
import { getSoa } from "./soa/getSoa";
import { getSoaPayments } from "./soa/getSoaPayments";
import { logout } from "./user/logout";
import { getServiceRequests } from "./requests/getServiceRequests";
import { getServiceRequestDetails } from "./requests/getServiceRequestDetails";
import { getGatepasses } from "./requests/getGatepasses";
import saveGatepass from "./requests/saveGatepass";
import { getGatepassTypes } from "./requests/getGatepassTypes";
import { getVisitorPasses } from "./requests/getVisitorPasses";
import saveVisitorPass from "./requests/saveVisitorPass";
import { getSoaDetails } from "./soa/getSoaDetails";

/**
* This object contains all the API functions for the client to make user related requests
*/
const user = {
    authenticate: authenticate,
    logout: logout,
}

const soa = {
    getSoa: getSoa,
    getSoaPayments: getSoaPayments,
    getSoaDetails: getSoaDetails,
}

const requests = {
    getServiceRequests: getServiceRequests,
    getServiceRequestDetails: getServiceRequestDetails,
    getGatepasses: getGatepasses,
    getGatepassTypes: getGatepassTypes,
    getVisitorPasses: getVisitorPasses,
    saveGatepass: saveGatepass,
    saveVisitorPass: saveVisitorPass,
}

const api = {
    user,
    soa,
    requests,
}

export default api;