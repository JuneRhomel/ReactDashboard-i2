import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import Layout from "@/components/layouts/layout";
import { CreateVisitorPassFormDataType, GuestDataType, VisitorsPassType } from "@/types/models";
import { useEffect, useState } from "react";
import parseFormErrors from "@/utils/parseFormErrors";
import api from "@/utils/api";
import ServiceRequestStatusFilter from "@/components/general/serviceRequestStatusFilter/ServiceRequestStatusFilter";
import styles from './VisitorPass.module.css';
import ServiceRequestCard from "@/components/general/cards/serviceRequestCard/ServiceRequestCard";
import DropdownForm from "@/components/general/dropdownForm/DropdownForm";
import CreateVisitorPassForm from "@/components/general/form/forms/createVisitorPassForm/CreateVisitorPassForm";

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

const VisitorPass = ({visitorPasses}: {visitorPasses: VisitorsPassType[]}) => {
    const maxNumberToShow = 4;
    const [formData, setFormData] = useState<CreateVisitorPassFormDataType>(testFormData);
    const [guestData, setGuestData] = useState<GuestDataType>(newGuest);
    const pendingVisitorPasses = visitorPasses.filter((visitorPass) => visitorPass.status === 'Pending');
    const approvedVisitorPasses = visitorPasses.filter((visitorPass) => visitorPass.status === 'Approved');
    const deniedVisitorPasses = visitorPasses.filter((visitorPass) => visitorPass.status === 'Disapproved');
    const [filteredVisitorPasses, setFilteredVisitorPasses] = useState<{[key: string]: VisitorsPassType[]}>({
        pending: pendingVisitorPasses,
        approved: approvedVisitorPasses,
        denied: deniedVisitorPasses,
    })

    const counts = {
        'pending': filteredVisitorPasses.pending.length,
        'approved': filteredVisitorPasses.approved.length,
        'denied': filteredVisitorPasses.denied.length,
    };

    const [gatepassesToShow, setVisitorPassesToShow] = useState<VisitorsPassType[]>(filteredVisitorPasses.pending.slice(0, maxNumberToShow));

    useEffect(() => {
        setVisitorPassesToShow(filteredVisitorPasses.pending.slice(0, maxNumberToShow));
    }, [filteredVisitorPasses])

    const serviceRequestStatusFilterHandler = (event: any) => {
        const filter = event?.target?.value;
        const filtered = filteredVisitorPasses[filter];
        setVisitorPassesToShow(filtered?.slice(0, maxNumberToShow) as VisitorsPassType[])
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
            const response = await api.requests.saveVisitorPass(formData);
            if (response.success) {
                pendingVisitorPasses.unshift(response.data?.visitorPass as VisitorsPassType);
                setFilteredVisitorPasses({...filteredVisitorPasses, pending: pendingVisitorPasses})
                return response;
            }
            return null;
        }
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Visitor Pass'/>

            <DropdownForm>
                <CreateVisitorPassForm handleInput={handleInput} formData={formData} setFormData={setFormData} onSubmit={handleSubmit}/>
            </DropdownForm>

            <ServiceRequestStatusFilter handler={serviceRequestStatusFilterHandler} counts={counts}/>

            <div className={styles.dataContainer}>
                {gatepassesToShow.length > 0 ? gatepassesToShow.map((visitorPass: VisitorsPassType, index: number) => (
                    <ServiceRequestCard key={index} request={visitorPass} variant="Visitor Pass"/>
                )) : <div>No data to display</div>}
            </div>
        </Layout>
    )
}

export default VisitorPass;