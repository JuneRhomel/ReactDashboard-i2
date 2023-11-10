import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import Layout from "@/components/layouts/layout";
import { CreateVisitorPassFormDataType, GuestDataType, UserType, VisitorsPassType } from "@/types/models";
import { useEffect, useState } from "react";
import parseFormErrors from "@/utils/parseFormErrors";
import api from "@/utils/api";
import StatusFilter from "@/components/general/statusFilter/StatusFilter";
import styles from './VisitorPass.module.css';
import ServiceRequestCard from "@/components/general/cards/serviceRequestCard/ServiceRequestCard";
import DropdownForm from "@/components/general/dropdownForm/DropdownForm";
import CreateVisitorPassForm from "@/components/general/form/forms/createVisitorPassForm/CreateVisitorPassForm";
import { useUserContext } from "@/context/userContext";

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

type VisitorPassProps = {
    authorizedUser: UserType,
    visitorPasses: VisitorsPassType[],
    errors: any[],
}

const VisitorPass = ({authorizedUser, visitorPasses, errors}: VisitorPassProps) => {
    const maxNumberToShow = 4;
    const {user, setUser} = useUserContext();
    useEffect(()=>{
        setUser(authorizedUser);
    },[])
    const [formData, setFormData] = useState<CreateVisitorPassFormDataType>(testFormData);
    const [guestData, setGuestData] = useState<GuestDataType>(newGuest);
    const [pendingVisitorPasses, setPendingVisitorPasses] = useState(visitorPasses?.filter((visitorPass) => visitorPass.status === 'Pending'));
    const [approvedVisitorPasses, setApprovedVisitorPasses] = useState(visitorPasses?.filter((visitorPass) => visitorPass.status === 'Approved'));
    const [deniedVisitorPasses, setDeniedVisitorPasses] = useState(visitorPasses?.filter((visitorPass) => visitorPass.status === 'Disapproved'));

    const [counts, setCounts] = useState({
        pending: pendingVisitorPasses?.length,
        approved: approvedVisitorPasses?.length,
        denied: deniedVisitorPasses?.length,
    });

    const passes = new Map<string, VisitorsPassType[]>([
        ['pending', pendingVisitorPasses],
        ['approved', approvedVisitorPasses],
        ['denied', deniedVisitorPasses],
    ])

    const [gatepassesToShow, setVisitorPassesToShow] = useState<VisitorsPassType[]>(pendingVisitorPasses?.slice(0, maxNumberToShow));

    useEffect(() => {
        setVisitorPassesToShow(pendingVisitorPasses?.slice(0, maxNumberToShow));
        setCounts({...counts, pending: pendingVisitorPasses?.length});
    }, [pendingVisitorPasses])

    const serviceRequestStatusFilterHandler = (event: any) => {
        const filter = event?.target?.value;
        const filtered = passes.get(filter);
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
                const newVisitorPass = response.data?.visitorPass as VisitorsPassType;
                setPendingVisitorPasses([newVisitorPass, ...pendingVisitorPasses]);
                return response;
            }
            return null;
        }
    }

    const statusTitles = ['Pending', 'Approved', 'Denied'];

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Visitor Pass'/>

            <DropdownForm>
                <CreateVisitorPassForm handleInput={handleInput} formData={formData} setFormData={setFormData} onSubmit={handleSubmit}/>
            </DropdownForm>

            <StatusFilter handler={serviceRequestStatusFilterHandler} counts={counts} titles={statusTitles}/>

            <div className={styles.dataContainer}>
                {gatepassesToShow?.length > 0 ? gatepassesToShow.map((visitorPass: VisitorsPassType, index: number) => (
                    <ServiceRequestCard key={index} request={visitorPass} variant="Visitor Pass"/>
                )) : <div>No data to display</div>}
            </div>
        </Layout>
    )
}

export default VisitorPass;