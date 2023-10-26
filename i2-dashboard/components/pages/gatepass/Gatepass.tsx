import ServiceRequestCard from "@/components/general/cards/serviceRequestCard/ServiceRequestCard";
import CreateServiceRequestForm from "@/components/general/form/forms/createServiceRequestForm/CreateServiceRequestForm";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import ServiceRequestStatusFilter from "@/components/general/serviceRequestStatusFilter/ServiceRequestStatusFilter";
import Layout from "@/components/layouts/layout";
import styles from './Gatepass.module.css';
import { CreateGatepassFormType, GatepassType, PersonnelDetailsType } from "@/types/models";
import { useState } from "react";
import parseFormErrors from "@/utils/parseFormErrors";
import api from "@/utils/api";

const title = 'i2 - Gate Pass'
const testFormData = {
    requestorName: 'Kevin',
    gatepassType: '1',
    forDate: '2023-12-12',
    time: '12:31',
    unit: '121',
    contactNumber: '9569784569',
    items: [
        {
            itemName: 'Item 1',
            itemQuantity: 2,
            itemDescription: 'Decsription 1'
        },
    ],
    personnel: {
        courier: 'Some Courier',
        courierName: 'Person 1',
        courierContact: '9991111122'
    },
}

const newPersonnel = {
    courier: '',
    courierName: '',
    courierContact: '',
}



const Gatepass = ({gatepasses}: {gatepasses: GatepassType[]}) => {
    const maxNumberToShow = 4;
    const [formData, setFormData] = useState<CreateGatepassFormType>(testFormData);

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

    const handleInput = (event: any) => {
        const name = event?.target?.name;
        const value = event?.target?.value;
        const newFormData: CreateGatepassFormType = {...formData};
        if (name.substring(0,7) === 'courier') {
            const newPersonnelData = formData.personnel || {...newPersonnel};
            newPersonnelData[name as keyof PersonnelDetailsType] = value;
            newFormData.personnel = newPersonnelData;
        } else {
            newFormData[name as keyof CreateGatepassFormType] = value;
        }
        setFormData(newFormData);
    }

    const handleSubmit = async (event: any) => {
        event.preventDefault();
        window.scrollTo(0,0);
        const form = document.getElementById('createGatepassForm') as HTMLFormElement;
        if (!form?.checkValidity()) {
            const errors = parseFormErrors(form);
            return null;
        } else {
            const response = await api.requests.saveGatepass(formData);
            if (response.success) {
                pendingGatepasses.unshift(response.data.gatepass as GatepassType);
                setGatepassesToShow(pendingGatepasses.slice(0, maxNumberToShow))
            }
            return response;
        }
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Gate Pass'/>

            <CreateServiceRequestForm
                type='Gate Pass'
                handleInput={handleInput}
                formData={formData}
                setFormData={setFormData}
                onSubmit={handleSubmit}
            />

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