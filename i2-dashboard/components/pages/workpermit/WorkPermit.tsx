import ServiceRequestCard from '@/components/general/cards/serviceRequestCard/ServiceRequestCard';
import styles from './WorkPermit.module.css';
import DropdownForm from "@/components/general/dropdownForm/DropdownForm";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import StatusFilter from "@/components/general/statusFilter/StatusFilter";
import Layout from "@/components/layouts/layout";
import { useUserContext } from '@/context/userContext';
import { UserType, WorkPermitType } from '@/types/models';
import { useEffect, useState } from 'react';
import CreateWorkPermitForm from '@/components/general/form/forms/createWorkPermitForm/CreateWorkPermitForm';

const title = "Work Permit";

type WorkPermitProps = {
    authorizedUser: UserType,
    workPermits: WorkPermitType[],
    errors?: any
}

const maxNumberToShow = 4;

export default function WorkPermit({authorizedUser, workPermits, errors}: WorkPermitProps) {
    const {user, setUser} = useUserContext();
    useEffect(()=> {
        setUser(authorizedUser);
    },[authorizedUser, setUser])
    const statusTitles = ['Open', 'Ongoing', 'Closed']
    const [openRequests, setOpenRequests] = useState(workPermits?.filter((permit) => permit.status === 'Open'));
    const [ongoingRequests, setOngoingRequests] = useState(workPermits?.filter((permit) => permit.status === 'Ongoing'));
    const [closedRequests, setClosedRequests] = useState(workPermits?.filter((permit) => permit.status === 'Closed'));
    const [workPermitsToShow, setWorkPermitsToShow] = useState(openRequests?.slice(0, maxNumberToShow))
    const [counts, setCounts] = useState<{[key: string]: number}>({
        'open': openRequests?.length,
        'ongoing': ongoingRequests?.length,
        'closed': closedRequests?.length,
    });

    useEffect(() => {
        setCounts({...counts, open: openRequests?.length});
        setWorkPermitsToShow(openRequests?.slice(0,maxNumberToShow));
    }, [openRequests])

    const permits = new Map<string, WorkPermitType[]>([
        ['open', openRequests],
        ['ongoing', ongoingRequests],
        ['closed', closedRequests],
    ])

    const workPermitFilterHandler = (event: any)=> {
        const filter = event.target.value;
        const toShow = permits.get(filter);
        setWorkPermitsToShow(toShow?.slice(0, maxNumberToShow) as WorkPermitType[]);
    }

    const addWorkPermitRequest = (newWorkPermit: WorkPermitType) => {
        setOpenRequests([newWorkPermit, ...openRequests]);
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title={title}/>

            <DropdownForm>
                <CreateWorkPermitForm key={user?.id} addWorkPermit={addWorkPermitRequest}/>
            </DropdownForm>

            <StatusFilter handler={workPermitFilterHandler} titles={statusTitles} counts={counts}/>
            <div className={styles.dataContainer}>
                {workPermitsToShow?.length > 0 ? workPermitsToShow.map((workPermit: WorkPermitType) => (
                    <ServiceRequestCard key={workPermit.id} request={workPermit} variant="Work Permit"/>
                )) : <div>No data to display</div>}
            </div>
        </Layout>
    )
}