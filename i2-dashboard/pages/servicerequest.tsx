import ServiceRequest from "@/components/pages/servicerequest/serviceRequest"
export async function getServerSideProps(context: any) {
    const serviceRequest = [
        {
            title: "Gate Pass",
            img: '/gatepass.png',
            link: '/gatepass'
        },
        {
            title: "Visitor Pass",
            img: '/visitorspass.png',
            link: '/'
        },
        {
            title: "Work Permit",
            img: '/workpermit.png',
            link: '/'
        },
        {
            title: "Report Issue",
            img: '/reportissue.png',
            link: '/'
        }
    ]

    return {
        props: {
            serviceRequest,
        }
    }
}

export default ServiceRequest