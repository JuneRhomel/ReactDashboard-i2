import ServiceRequestCard from "@/components/general/cards/serviceRequestCard/ServiceRequestCard";
import CreateServiceRequestForm from "@/components/general/form/forms/createServiceRequestForm/CreateServiceRequestForm";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import ServiceRequestStatusFilter from "@/components/general/serviceRequestStatusFilter/ServiceRequestStatusFilter";
import Layout from "@/components/layouts/layout";
import { ServiceRequestType } from "@/types/models";

const title = 'i2 - Gate Pass'
const Gatepass = (props: any) => {
    const serviceRequests = props.serviceRequests
    const serviceRequestStatusFilterHandler = () => {
        
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Gate Pass'/>

            <CreateServiceRequestForm type='Gate Pass'/>

            <ServiceRequestStatusFilter handler={serviceRequestStatusFilterHandler}/>
            {serviceRequests.map((serviceRequest: ServiceRequestType, index: number) => (
                <ServiceRequestCard key={index} request={serviceRequest}/>
            ))}
        </Layout>
    )
}

export default Gatepass;