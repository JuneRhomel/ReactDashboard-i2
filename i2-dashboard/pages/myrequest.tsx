import MyRequest from "@/components/pages/myrequest/MyRequest";
import { ParamGetSoaDetailsType, ParamGetSoaType, SoaDetailsType, SoaType } from "@/types/models";
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";
import mapObject from "@/utils/mapObject";

export async function getServerSideProps(context: any) {
    const myRequest = [
        {
            id: "36",
            date_upload: "October 09, 2023 04:57 PM",
            type: "Gate Pass",
            table: "vw_gatepass",
            data: {
                id: "36",
                gp_personnel: [
                    {
                        id: "204",
                        gatepass_id: "36",
                        personnel_name: "June Rhomel",
                        company_name: "JNT",
                        personnel_description: null,
                        personnel_no: "093454656",
                        enc_id: "b0Z4MFR5RUtJT3c3TlB5YmVqU3BFUT09.fcf4ed0f50d53072927d0d99738d9365"
                    },
                    {
                        id: "204",
                        gatepass_id: "36",
                        personnel_name: "June Rhomel",
                        company_name: "JNT",
                        personnel_description: null,
                        personnel_no: "093454656",
                        enc_id: "b0Z4MFR5RUtJT3c3TlB5YmVqU3BFUT09.fcf4ed0f50d53072927d0d99738d9365"
                    },
                ],
                gp_date: "2023-08-31",
                gp_time: "05:16:00 PM",
                contact_no: "09154560789",
                status: "Pending",
                date_upload: "August 30, 2023 05:16 PM",
                firstname: "Admin",
                lastname: "De Vera",
                fullname: "Admin De Vera",
                unit: "Unit 101",
                type: "Move In",
            }
        },
        {
            id: "34",
            date_upload: "August 30, 2023 05:16 PM",
            type: "Report Issue",
            table: "vw_report_issue",
            data: {
                id: "190",
                issue_id: "34",
                issue_name: "Landscaping",
                firstname: "Admin",
                lastname: "De Vera",
                fullname: "Admin De Vera",
                status: "Open",
                contact_no: "09154560789",
                location_name: null,
                description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aliquam quas voluptate ullam. Voluptas odio ea corrupti nesciunt qui dignissimos perferendis eligendi quisquam soluta dolorem, minus esse molestiae excepturi officia?",
                status_id: "42",
                attachments: "http://apii2-sandbox.inventiproptech.com/uploads/reportissue/2359016a-2ef4-4ff3.png",
                date_upload: "October 09, 2023 04:57 PM",
                enc_id: "Nm5jakQ4VkM1aVdLVXNjQ1JiUUVRdz09.36fc45ec2a23c76e42a5d144a85f781c"
            }
        },
        {
            id: "34",
            date_upload: "August 30, 2023 05:15 PM",
            type: "Visitor Pass",
            table: "vw_visitor_pass",
            data: {
                id: "34",
                name_id: "1",
                firstname: "Admin",
                lastname: "De Vera",
                fullname: "Admin De Vera",
                guest: [
                    {
                        id: "73",
                        guest_id: "34",
                        guest_name: "june Rhomel",
                        guest_no: "092334554",
                        guest_purpose: "Visit",
                        created_by: "1",
                        created_on: "1691731023",
                        deleted_by: "0",
                        deleted_on: "0",
                        enc_id: "ZHd6Uk9rSEdvU0RzWjZ1bmZnNUphQT09.cadff71d89742246399d343384d290a3"
                    },
                    {
                        id: "73",
                        guest_id: "34",
                        guest_name: "june Rhomel",
                        guest_no: "092334554",
                        guest_purpose: "Visit",
                        created_by: "1",
                        created_on: "1691731023",
                        deleted_by: "0",
                        deleted_on: "0",
                        enc_id: "ZHd6Uk9rSEdvU0RzWjZ1bmZnNUphQT09.cadff71d89742246399d343384d290a3"
                    },
                ],
                unit_id: "5",
                contact_no: "09154560789",
                departure_date: "2023-08-04",
                arrival_date: "2023-08-04",
                arrival_time: "01:16 PM",
                departure_time: "03:16 PM",
                date_upload: "August 11, 2023 01:16 PM",
                approve_id: "1",
                status: "Approved",
                location_name: "Unit 101",
                enc_id: "VnBzUzRFTjE3RnVrTkpqeU11bUlhQT09.deb6ff5995e364026c535aaeaa4e6f29"

            }
        },
        {
            id: "188",
            date_upload: "August 30, 2023 05:13 PM",
            type: "Work Permit",
            table: "vw_workpermit",
            data: {
                id: "188",
                location_name: "Unit 101",
                category_name: "Installation",
                firstname: "Admin",
                lastname: "De Vera",
                status: "Disapproved",
                fullname: "Admin De Vera",
                unit_id: "5",
                contact_no: "09154560789",
                start_date: "2023-08-30",
                end_date: "2023-08-30",
                status_id: "68",
                workpermitcategory_id: "1",
                work_details_id: "61",
                work_details: [
                    {
                        id: "61",
                        name_contractor: "Jr",
                        scope_work: "Work",
                        person_charge: "Ian",
                        contact_number: "565656",
                        enc_id: "cDNNdmNCL2dMR3RtUGRHSzNWUEY0QT09.e913e81bf020772eb40afaf2c395c7c6"
                    },
                    {
                        id: "61",
                        name_contractor: "BBGD",
                        scope_work: "Update",
                        person_charge: "Ian",
                        contact_number: "565656",
                        enc_id: "cDNNdmNCL2dMR3RtUGRHSzNWUEY0QT09.e913e81bf020772eb40afaf2c395c7c6"
                    },
                ],
                date_upload: "August 29, 2023 08:05 PM",
                name_id: "1",
                enc_id: "R2JrRlhuSHR0T3dQVDIzY3R1SnhvUT09.c5781ca58f4e8df3fbd4e14b1bdff8f3"
            }
        }
    ];

    return {
        props: {
            myRequest,
        }
    }
}

export default MyRequest