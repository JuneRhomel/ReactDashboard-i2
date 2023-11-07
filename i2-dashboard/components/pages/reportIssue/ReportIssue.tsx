import ServiceRequestCard from '@/components/general/cards/serviceRequestCard/ServiceRequestCard';
import styles from './ReportIssue.module.css';
import DropdownForm from "@/components/general/dropdownForm/DropdownForm";
import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import StatusFilter from "@/components/general/statusFilter/StatusFilter";
import Layout from "@/components/layouts/layout";
import { ServiceIssueType } from '@/types/models';
import { useState } from 'react';

const title = 'Report Issue';
const maxNumberToShow = 4;
export default function ReportIssue({issues, error}: {issues: ServiceIssueType[], error: any}) {
    if (error) {
        return (
            <Layout title={title}>
                <h1>{error}</h1>
            </Layout>
        )
    }
    
    const counts: {[key: string]: number} = {
        'Open': 0,
        'Ongoing': 0,
        'Closed': 0,
    }
    
    // Change this to a useEffect()
    const processIssues = async (issues: ServiceIssueType[]) => {
        const serviceIssues: {[key: string]: ServiceIssueType[]}= {
            'Open': [],
            'Ongoing': [],
            'Closed': [],
        };
        await Promise.all(issues.map((issue) => {
            serviceIssues[issue.status].push(issue);
            counts[issue.status]++;
        }));

        console.log(serviceIssues)
        setServiceIssues(serviceIssues);
    }
    const [serviceIssues, setServiceIssues] = useState<{[key: string]: ServiceIssueType[]} | null>(null);


    const [serviceIssuesToShow, setServiceIssuesToShow] = useState(serviceIssues?.Open.slice(0, maxNumberToShow))
    const statusTitles = ['Open', 'Ongoing', 'Closed']

    return (
        <Layout title={title}>
            <ServiceRequestPageHeader title={title}/>

            <DropdownForm>
                {/* <CreateReportIssueForm /> */}
                Report Issue Form
            </DropdownForm>

            <StatusFilter handler={()=>{}} counts={counts} titles={statusTitles}/>

            <div className={styles.dataContainer}>
                {serviceIssuesToShow?.map((issue) => (
                    <ServiceRequestCard key={issue.id} request={issue} variant='Report Issue'/>    
                ))}
            </div>
        </Layout>
    )
}