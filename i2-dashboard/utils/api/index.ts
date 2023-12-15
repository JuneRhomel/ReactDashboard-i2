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
import saveSoaPayment from "./soa/saveSoaPayment";
import { getIssues } from "./requests/getIssues";
import { getIssueCategories } from "./requests/getIssueCategories";
import saveReportIssue from "./requests/saveReportIssue";
import { getWorkPermits } from "./requests/getWorkPermits";
import { getWorkPermitTypes } from "./requests/getWorkPermitTypes";
import saveWorkPermit from "./requests/saveWorkPermit";
import { getSysteminfo } from './systeminfo/getSysteminfo';
import { getNewsAnnouncements } from './newsannouncements/getNewsAnnouncements';
import { getServiceRequestComments } from './requests/getServiceRequestComments';
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
    saveSoaPayment: saveSoaPayment,
}

const requests = {
    getServiceRequests: getServiceRequests,
    getServiceRequestDetails: getServiceRequestDetails,
    getGatepasses: getGatepasses,
    getGatepassTypes: getGatepassTypes,
    getVisitorPasses: getVisitorPasses,
    getIssues: getIssues,
    getIssueCategories: getIssueCategories,
    getWorkPermits: getWorkPermits,
    getWorkPermitTypes: getWorkPermitTypes,
    getServiceRequestComments: getServiceRequestComments,
    saveGatepass: saveGatepass,
    saveVisitorPass: saveVisitorPass,
    saveReportIssue: saveReportIssue,
    saveWorkPermit: saveWorkPermit,
}
const systeminfo = {
    getSysteminfo: getSysteminfo
}

const newsAnnouncements = {
    getNewsAnnouncements: getNewsAnnouncements
}
const api = {
    user,
    soa,
    requests,
    systeminfo,
    newsAnnouncements,
}

export default api;