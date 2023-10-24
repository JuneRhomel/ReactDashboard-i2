import ServiceRequestCard from "@/components/general/cards/serviceRequestCard/ServiceRequestCard";
import CreateServiceRequestForm from "@/components/general/form/forms/createServiceRequestForm/CreateServiceRequestForm";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import ServiceRequestStatusFilter from "@/components/general/serviceRequestStatusFilter/ServiceRequestStatusFilter";
import Layout from "@/components/layouts/layout";
import styles from './Gatepass.module.css';
import { GatePassType } from "@/types/models";
import { useState } from "react";

const title = 'i2 - Gate Pass'
const Gatepass = ({gatePasses}: {gatePasses: GatePassType[]}) => {
    const maxNumberToShow = 4;
    const pendingGatePasses = gatePasses.filter((gatepass) => gatepass.status === 'Pending');
    const approvedGatePasses = gatePasses.filter((gatepass) => gatepass.status === 'Approved');
    const deniedGatePasses = gatePasses.filter((gatepass) => gatepass.status === 'Denied');
    const filteredPasses = new Map<string, GatePassType[]>([
        ['pending', pendingGatePasses],
        ['approved', approvedGatePasses],
        ['denied', deniedGatePasses],
    ])
    const counts = {
        'pending': pendingGatePasses.length,
        'approved': approvedGatePasses.length,
        'denied': deniedGatePasses.length
    };
    const [gatePassesToShow, setGatePassesToShow] = useState<GatePassType[]>(pendingGatePasses.slice(0, maxNumberToShow));

    const serviceRequestStatusFilterHandler = (event: any) => {
        const filter = event?.target?.value;
        const filtered = filteredPasses.get(filter);
        setGatePassesToShow(filtered?.slice(0, maxNumberToShow) as GatePassType[])
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Gate Pass'/>

            <CreateServiceRequestForm type='Gate Pass'/>

            <ServiceRequestStatusFilter handler={serviceRequestStatusFilterHandler} counts={counts}/>

            <div className={styles.dataContainer}>
                {gatePassesToShow.length > 0 ? gatePassesToShow.map((gatePass: GatePassType, index: number) => (
                    <ServiceRequestCard key={index} request={gatePass} variant="Gate Pass"/>
                )) : <div>No data to display</div>}
            </div>
        </Layout>
    )
}

export default Gatepass;