import Layout from '@/components/layouts/layout';
import styles from "./ServiceRequest.module.css"
import ServiceRequests from '@/components/general/section/Servicerequest/Servicerequest';

const ServiceRequest = ({ serviceRequest }: any) => {
    console.log(serviceRequest)
    return (
        <Layout title="My Request">
            <div className={styles.container}>
                <ServiceRequests props={serviceRequest} />
            </div>
        </Layout>
    );
}

export default ServiceRequest