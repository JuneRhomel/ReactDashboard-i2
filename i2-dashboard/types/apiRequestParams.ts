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
export type ParamGetSystemInfoType = {
    accountcode: string,
    soaId?: number,
    limit?: number,
}
export type ParamGetNews = {
    table?: any | null,
    accountcode: string,
    limit?: number,
}
export type ParamGetServiceRequestComments = {
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
export interface ParamGetServiceRequestsParamsType {
    accountcode: string,
    userId?: number,
    limit?: number,
    id?: number,
}

export type ServiceRequestTable = 'personnel' | 'vp_guest' | 'work_details' | 'gatepass' | 'visitor_pass' | 'report_issue' | 'workpermit' | 'comments'

export type ModuleType = 'gatepass' | 'visitorpass' | 'soa_payment' | 'reportissue' | 'workpermit'
export type VisitorPassTables = 'visitorpass' | 'vp_guest';
export type GatepassTables = 'gatepass' | 'gatepass_personnel' | 'gatepass_items';
export type WorkPermitTables = 'work_details' | 'workers' | 'work_materials' | 'work_tools' | 'workpermit';
export type TableType = GatepassTables | VisitorPassTables | 'soa_payment' | 'report_issue' | WorkPermitTables;

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

export interface ParamSaveReportIssueType extends BaseSaveParams{
    status_id: string,
    created_by: string,
    description: string,
    attachments: FileDataType[],
    issue_id: string,
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

export interface ParamSaveWorkDetailsType {
    module: ModuleType,
    table: WorkPermitTables,
    name_contractor: string,
    scope_work: string,
    person_charge: string,
    contact_number: string
}

export interface ParamSaveWorkPersonnelType {
    module: ModuleType,
    table: WorkPermitTables,
    workpermit_id: string,
    personnel_name: string,
    personnel_description: string,
}

export interface ParamSaveWorkMaterialsType {
    module: ModuleType,
    table: WorkPermitTables,
    workpermit_id: string,
    materials_name: string,
    quantity_materials: string,
    description_materials: string,
}

export interface ParamSaveWorkToolsType {
    module: ModuleType,
    table: WorkPermitTables,
    workpermit_id: string,
    tools_name: string,
    tools_qty: string,
    tools_desc: string,
}

export interface ParamSaveWorkPermitType {
    date: string,
    module: ModuleType,
    table: WorkPermitTables,
    name_id: string,
    unit_id: string,
    work_details_id: string,
    workpermitcategory_id: string,
    start_date: string,
    end_date: string,
    contact_no: string,
}