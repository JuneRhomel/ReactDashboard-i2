import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import Layout from "@/components/layouts/layout";
import { CreateGatepassFormType, CreateVisitorPassFormDataType, GatepassType, GuestDataType, PersonnelDetailsType } from "@/types/models";
import { useEffect, useState } from "react";
import parseFormErrors from "@/utils/parseFormErrors";
import api from "@/utils/api";
import CreateServiceRequestForm from "@/components/general/form/forms/createServiceRequestForm/CreateServiceRequestForm";
import ServiceRequestStatusFilter from "@/components/general/serviceRequestStatusFilter/ServiceRequestStatusFilter";

const title = 'i2 - Visitor Pass'
const testFormData = {
    requestorName: 'Kevin',
    unit: 'Unit 5',
    contactNumber: '1234567894',
    arrivalDate: '2023-12-05',
    arrivalTime: '11:22',
    departureDate: '2023-12-07',
    departureTime: '22:33',
    guests: []
}

const newGuest: GuestDataType = {
    guestName: '',
    guestContact: '',
    guestPurpose: '',
}

const VisitorPass = ({gatepasses}: {gatepasses: GatepassType[]}) => {
    const maxNumberToShow = 4;
    const [formData, setFormData] = useState<CreateVisitorPassFormDataType>(testFormData);
    const [guestData, setGuestData] = useState<GuestDataType>(newGuest);
    const pendingGatepasses = gatepasses.filter((gatepass) => gatepass.status === 'Pending');
    const approvedGatepasses = gatepasses.filter((gatepass) => gatepass.status === 'Approved');
    const deniedGatepasses = gatepasses.filter((gatepass) => gatepass.status === 'Disapproved');
    const [filteredGatepasses, setFilteredGatepasses] = useState<{[key: string]: GatepassType[]}>({
        pending: pendingGatepasses,
        approved: approvedGatepasses,
        denied: deniedGatepasses,
    })

    const counts = {
        'pending': filteredGatepasses.pending.length,
        'approved': filteredGatepasses.approved.length,
        'denied': filteredGatepasses.denied.length,
    };

    const [gatepassesToShow, setGatepassesToShow] = useState<GatepassType[]>(filteredGatepasses.pending.slice(0, maxNumberToShow));

    useEffect(() => {
        setGatepassesToShow(filteredGatepasses.pending.slice(0, maxNumberToShow));
    }, [filteredGatepasses])

    const serviceRequestStatusFilterHandler = (event: any) => {
        const filter = event?.target?.value;
        const filtered = filteredGatepasses[filter];
        setGatepassesToShow(filtered?.slice(0, maxNumberToShow) as GatepassType[])
    }

    const handleInput = (event: any) => {
        const name = event?.target?.name as string;
        const value = event?.target?.value;
        const newFormData: CreateVisitorPassFormDataType = {...formData};
        if (name.substring(0,5) === 'guest') {
            const newGuestData = guestData;
            newGuestData[name as keyof GuestDataType] = value;
            newFormData.guests.push(newGuestData);
        } else {
            newFormData[name as keyof CreateVisitorPassFormDataType] = value;
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
            // const response = await api.requests.saveGatepass(formData);
            // if (response.success) {
            //     pendingGatepasses.unshift(response.data.gatepass as GatepassType);
            //     setFilteredGatepasses({...filteredGatepasses, pending: pendingGatepasses})
            //     return response;
            // }
            return null;
        }
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Visitor Pass'/>

            <CreateServiceRequestForm
                type='visitorpass'
                handleInput={handleInput}
                formData={formData}
                setFormData={setFormData as any} // Need to fix the Typing for this
                onSubmit={handleSubmit}
            />

            <ServiceRequestStatusFilter handler={serviceRequestStatusFilterHandler} counts={counts}/>

            {/* <div className={styles.dataContainer}>
                {gatepassesToShow.length > 0 ? gatepassesToShow.map((gatepass: GatepassType, index: number) => (
                    <ServiceRequestCard key={index} request={gatepass} variant="Gate Pass"/>
                )) : <div>No data to display</div>}
            </div> */}
        </Layout>
    )
}

export default VisitorPass;