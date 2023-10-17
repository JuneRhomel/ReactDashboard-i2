import Layout from '@/components/layouts/layout';
import styles from "./SelectServiceRequest.module.css"
import { ServiceRequestsThumbnailData } from '@/types/models';
import Section from '@/components/general/section/Section';

const SelectServiceRequest = () => {
    const thumbnailData: ServiceRequestsThumbnailData[] = [
        {
            title: "Gate Pass",
            img: '/gatepass.png',
            link: '/gatepass'
        },
        {
            title: "Visitor Pass",
            img: '/visitorspass.png',
            link: '/'
        },
        {
            title: "Work Permit",
            img: '/workpermit.png',
            link: '/'
        },
        {
            title: "Report Issue",
            img: '/reportissue.png',
            link: '/'
        }
    ]

    const props = {
        title: 'select service request',
        headerAction: null,
        data: thumbnailData,
    }

    return (
        <Layout title="i2 - Service Requests">
            <div className={styles.container}>
                <Section props={props}/>
            </div>
        </Layout>
    );
}

export default SelectServiceRequest;