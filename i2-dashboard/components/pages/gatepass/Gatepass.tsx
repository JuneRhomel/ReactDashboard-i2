import ServiceRequestCard from "@/components/general/cards/serviceRequestCard/ServiceRequestCard";
import CreateServiceRequestForm from "@/components/general/form/forms/createServiceRequestForm/CreateServiceRequestForm";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import ServiceRequestStatusFilter from "@/components/general/serviceRequestStatusFilter/ServiceRequestStatusFilter";
import Layout from "@/components/layouts/layout";
import styles from './Gatepass.module.css';
import { GatepassType } from "@/types/models";
import { useState } from "react";

const title = 'i2 - Gate Pass'
const Gatepass = ({gatepasses}: {gatepasses: GatepassType[]}) => {
    const maxNumberToShow = 4;
    const pendingGatepasses = gatepasses.filter((gatepass) => gatepass.status === 'Pending');
    const approvedGatepasses = gatepasses.filter((gatepass) => gatepass.status === 'Approved');
    const deniedGatepasses = gatepasses.filter((gatepass) => gatepass.status === 'Denied');
    const filteredPasses = new Map<string, GatepassType[]>([
        ['pending', pendingGatepasses],
        ['approved', approvedGatepasses],
        ['denied', deniedGatepasses],
    ])
    const counts = {
        'pending': pendingGatepasses.length,
        'approved': approvedGatepasses.length,
        'denied': deniedGatepasses.length
    };
    const [gatepassesToShow, setGatepassesToShow] = useState<GatepassType[]>(pendingGatepasses.slice(0, maxNumberToShow));

    const serviceRequestStatusFilterHandler = (event: any) => {
        const filter = event?.target?.value;
        const filtered = filteredPasses.get(filter);
        setGatepassesToShow(filtered?.slice(0, maxNumberToShow) as GatepassType[])
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Gate Pass'/>

            <CreateServiceRequestForm type='Gate Pass'/>

            <ServiceRequestStatusFilter handler={serviceRequestStatusFilterHandler} counts={counts}/>

            <div className={styles.dataContainer}>
                {gatepassesToShow.length > 0 ? gatepassesToShow.map((gatepass: GatepassType, index: number) => (
                    <ServiceRequestCard key={index} request={gatepass} variant="Gate Pass"/>
                )) : <div>No data to display</div>}
            </div>
        </Layout>
    )
}

export default Gatepass;