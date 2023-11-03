import { ReactNode } from 'react';
import PaymentTransactions from './paymentTransactions/PaymentTransactions';
import SoaCard from '../cards/soaCard/SoaCard';
import styles from './Section.module.css';
import ServiceRequests from './serviceRequests/ServiceRequests';
import ServiceRequestThumbnails from './serviceRequestThumbnails/ServiceRequestThumbnails';
import { SoaPaymentsType, SoaType } from '@/types/models';
import SoaButtons from '../button/SoaButtons';

const Section = ({props}: {props: any}) => {
    const title = props?.title.toLowerCase();
    const cardMap: Record<string, ReactNode> = {
        'soa': <SoaCard currentSoa={props.data?.currentSoa as SoaType} currentSoaPayments={props.data?.soaDetails as SoaPaymentsType[]}><SoaButtons payAction={()=>{}}/></SoaCard>,
        'payment transactions': <PaymentTransactions transactions={props.data}/>,
        'my requests': <ServiceRequests serviceRequests={props.data}/>,
        'select service request': <ServiceRequestThumbnails/>,
        'service requests': <ServiceRequestThumbnails/>
    }
    const componentToRender: ReactNode = cardMap[title];

    return (
        <>
            { title !== 'select service request' ? 
                <div className={styles.header}>
                    <h1 className={styles.title}>{props.title}</h1>
                    {props.headerAction ? <h2 className={styles.action}>{props.headerAction}</h2> : <></>}
                </div>
                :
                <></>
            }

            {componentToRender}
        </>
    )
}

export default Section