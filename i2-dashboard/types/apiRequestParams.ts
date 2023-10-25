export type ParamGetSoaType = {
    accountcode: string,
    userId: number,
    limit?: number,
}

export type ParamGetSoaDetailsType = {
    accountcode: string,
    soaId: number,
    limit?: number,
}

export interface ParamGetServiceRequestType {
    accountcode: string,
    userId: number,
    limit?: number,
}

export type ServiceRequestTable = 'personnel' | 'vp_guest' | 'work_details' | 'gatepass' | 'visitor_pass' | 'report_issue' | 'workpermit'

export type ModuleType = 'gatepass';

export type GatepassTables = 'gatepass' | 'gatepass_personnel' | 'gatepass_items';
export type TableType = GatepassTables;


export interface ParamSaveGatepassType {
    date: string,
    module: ModuleType,
    table: TableType,
    name_id: string,
    unit_id: string,
    gp_type: string,
    gp_date: string,
    gp_time: string,
    contact_no: string,
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