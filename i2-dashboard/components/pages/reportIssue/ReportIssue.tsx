import ServiceRequestCard from '@/components/general/cards/serviceRequestCard/ServiceRequestCard';
import styles from './ReportIssue.module.css';
import DropdownForm from "@/components/general/dropdownForm/DropdownForm";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import StatusFilter from "@/components/general/statusFilter/StatusFilter";
import Layout from "@/components/layouts/layout";
import {  ServiceIssueType, UserType } from '@/types/models';
import { useEffect, useState } from 'react';
import CreateReportIssueForm from '@/components/general/form/forms/createReportIssueForm/CreateReportIssueForm';
import { useUserContext } from '@/context/userContext';

const title = 'Report Issue';
const maxNumberToShow = 4;

type ReportIssueProps = {
    authorizedUser: UserType,
    issues: ServiceIssueType[],
    errors: any
}

export default function ReportIssue({authorizedUser, issues, errors}: ReportIssueProps) {
    const {user, setUser} = useUserContext();
    setUser(authorizedUser);
    const [openIssues, setOpenIssues] = useState(issues?.filter((issue) => issue.status === 'Open'));
    const [ongoingIssues, setOngoingIssues] = useState(issues?.filter((issue) => issue.status === 'Ongoing'));
    const [closedIssues, setClosedIssues] = useState(issues?.filter((issue) => issue.status === 'Closed'));
    
    const [counts, setCounts] = useState<{[key: string]: number}>({
        'open': openIssues?.length,
        'ongoing': ongoingIssues?.length,
        'closed': closedIssues?.length,
    });
    
    const serviceIssues = new Map<string, ServiceIssueType[]>([
        ['open', openIssues],
        ['ongoing', ongoingIssues],
        ['closed', closedIssues],
    ])

    const [serviceIssuesToShow, setServiceIssuesToShow] = useState(serviceIssues.get('open')?.slice(0, maxNumberToShow))
    const statusTitles = ['Open', 'Ongoing', 'Closed']

    useEffect(() => {
        setCounts({...counts, open: openIssues?.length});
        setServiceIssuesToShow(openIssues?.slice(0,maxNumberToShow));
    },[openIssues])

    const filterHandler = (event: any) => {
        const filter = event.target.value;
        const toShow = serviceIssues.get(filter);
        setServiceIssuesToShow(toShow?.slice(0,maxNumberToShow));
    }

    const addServiceIssue = (newIssue: ServiceIssueType) => {
        setOpenIssues([newIssue, ...openIssues]);
    }

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title={title}/>
            <DropdownForm>
                <CreateReportIssueForm addServiceIssue={addServiceIssue}/>
            </DropdownForm>

            <StatusFilter handler={filterHandler} counts={counts} titles={statusTitles}/>

            <div className={styles.dataContainer}>
                {serviceIssuesToShow?.map((issue) => (
                    <ServiceRequestCard key={issue.id} request={issue} variant='Report Issue'/>    
                ))}
            </div>
        </Layout>
    )
}