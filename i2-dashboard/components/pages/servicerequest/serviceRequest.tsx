import Layout from '@/components/layouts/layout';
import styles from "./ServiceRequest.module.css"
import MyRequests from '@/pages/myrequests';
import { ListRequest } from '@/types/models';

const Servicerequest = ({ serviceRequest }: any) => {
    console.log(serviceRequest)
    return (
        <Layout title="My Request">
            <div className={styles.container}>
                <MyRequests props={serviceRequest} />
            </div>
        </Layout>
    );
}

export default Servicerequest