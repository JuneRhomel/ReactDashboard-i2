export type ParamGetSoaType = {
    accountcode: string,
    userId?: number,
    soaId?: string,
    limit?: number,
}

export type ParamGetSoaDetailsType = {
    accountcode: string,
    soaId?: number,
    limit?: number,
}

export interface ParamGetServiceRequestType {
    accountcode: string,
    userId?: number,
    limit?: number,
    id?: number,
}

export type ServiceRequestTable = 'personnel' | 'vp_guest' | 'work_details' | 'gatepass' | 'visitor_pass' | 'report_issue' | 'workpermit'

export type ModuleType = 'gatepass' | 'visitorpass' | 'soa_payment';
export type VisitorPassTables = 'visitorpass' | 'vp_guest';
export type GatepassTables = 'gatepass' | 'gatepass_personnel' | 'gatepass_items';
export type TableType = GatepassTables | VisitorPassTables | 'soa_payment';

export interface BaseSaveParams {
    date: string,
    module: ModuleType,
    table: TableType,
    name_id: string,
    unit_id: string,
    contact_no: string,    
}
export interface ParamSaveGatepassType extends BaseSaveParams {
    gp_type: string,
    gp_date: string,
    gp_time: string,
}

export interface ParamGatepassPersonnelType {
    gatepass_id: string,
    module: ModuleType,
    table: TableType,
    company_name: string,
    personnel_name: string,
    personnel_no: string,
}

export interface ParamGatepassItemType {
    item_name: string,
    item_qty: string,
    module: ModuleType,
    table: TableType,
    description: string,
    gatepass_id: string,
}

export interface ParamSaveVisitorPassType extends BaseSaveParams {
    arrival_date: string,
    arrival_time: string,
    departure_date: string,
    departure_time: string,
}

export interface ParamSaveGuestListType {
    module: ModuleType,
    table: TableType,
    guest_id: string,
    guest_name: string,
    guest_no: string,
    guest_purpose: string,
}

export interface FileDataType {
    filename: string,
    data: string,
}

export interface ParamSaveSoaPayment {
    module: ModuleType,
    table: TableType,
    soa_id: string,
    payment_type: string,
    status: string,
    particular: string,
    amount: string,
    attachments: FileDataType[],
}