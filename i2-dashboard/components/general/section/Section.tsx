import { ReactNode } from 'react';
import PaymentTransactions from './paymentTransactions/PaymentTransactions';
import SoaCard from '../cards/soaCard/SoaCard';
import styles from './Section.module.css';
import Request from './request/Request';
const Section = ({props}: {props: any}) => {
    const title = props?.title.toLowerCase();
    
    const cardMap: Record<string, ReactNode> = {
        'soa': <SoaCard props={props.data}/>,
        'payment transactions': <PaymentTransactions transactions={props.data}/>,
        'my request': <Request myRequest={props.data} />
    }
    const componentToRender: ReactNode = cardMap[title];

    return (
        <>
            <div className={styles.header}>
                <h1 className={styles.title}>{props.title}</h1>
                {props.headerAction ? <h2 className={styles.action}>{props.headerAction}</h2> : <></>}
            </div>

            {componentToRender}
        </>
    )
}

export default Section