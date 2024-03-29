import ServiceRequestCard from "@/components/general/cards/serviceRequestCard/ServiceRequestCard";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import Layout from "@/components/layouts/layout";
import styles from './Gatepass.module.css';
import { CreateGatepassFormType, GatepassType, PersonnelDetailsType, UserType } from "@/types/models";
import { useEffect, useState } from "react";
import parseFormErrors from "@/utils/parseFormErrors";
import api from "@/utils/api";
import DropdownForm from "@/components/general/dropdownForm/DropdownForm";
import CreateGatepassForm from "@/components/general/form/forms/createGatepassForm/CreateGatepassForm";
import StatusFilter from "@/components/general/statusFilter/StatusFilter";
import { useUserContext } from "@/context/userContext";
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

type GatepassProps = {
    authorizedUser: UserType,
    gatepasses: GatepassType[],
    error : any[] | null,
}

//TODO Update the counts onSubmit
const Gatepass = ({authorizedUser, gatepasses, error}: GatepassProps) => {
    const maxNumberToShow = 4;
    const {user, setUser} = useUserContext();
    useEffect(()=> {
        setUser(authorizedUser);
    },[])
    const [formData, setFormData] = useState<CreateGatepassFormType>(testFormData);
    const [pendingGatepasses, setPendingGatepasses] = useState(gatepasses?.filter((gatepass) => gatepass.status === 'Pending'));
    const [approvedGatepasses, setApprovedGatepasses] = useState(gatepasses?.filter((gatepass) => gatepass.status === 'Approved'));
    const [deniedGatepasses, setDeniedGatepasses] = useState(gatepasses?.filter((gatepass) => gatepass.status === 'Disapproved'));
    const [gatepassesToShow, setGatepassesToShow] = useState<GatepassType[]>(pendingGatepasses?.slice(0, maxNumberToShow));

    const passes = new Map<string, GatepassType[]>([
        ['pending', pendingGatepasses],
        ['approved', approvedGatepasses],
        ['denied', deniedGatepasses],
    ])

    const [counts, setCounts] = useState({
        'pending': pendingGatepasses?.length,
        'approved': approvedGatepasses?.length,
        'denied': deniedGatepasses?.length,
    });

    useEffect(() => {
        setGatepassesToShow(pendingGatepasses?.slice(0, maxNumberToShow));
        setCounts({...counts, pending: pendingGatepasses?.length});
    }, [pendingGatepasses])

    const serviceRequestStatusFilterHandler = (event: any) => {
        const filter = event?.target?.value;
        const filtered = passes.get(filter);
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
                const newPass = response.data?.gatepass as GatepassType;
                setPendingGatepasses([newPass, ...pendingGatepasses])
                return response;
            }
            return null;
        }
    }

    const filterTitles = ['Pending', 'Approved', 'Denied']

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title='Gate Pass'/>

            <DropdownForm>
                <CreateGatepassForm handleInput={handleInput} formData={formData} setFormData={setFormData} onSubmit={handleSubmit}/>
            </DropdownForm>

            <StatusFilter handler={serviceRequestStatusFilterHandler} counts={counts} titles={filterTitles}/>

            <div className={styles.dataContainer}>
                {gatepassesToShow?.length > 0 ? gatepassesToShow.map((gatepass: GatepassType, index: number) => (
                    <ServiceRequestCard key={index} request={gatepass} variant="Gate Pass"/>
                )) : <div>No data to display</div>}
            </div>
        </Layout>
    )
}

export default Gatepass;