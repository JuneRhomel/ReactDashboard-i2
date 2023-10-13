import styles from './SoaCard.module.css'
import Link from 'next/link'
import getDateString from '@/utils/getDateString';
const SoaCard = ({ props }: { props: any }) => {
    const status = props?.status;
    const statementDate = getDateString(null, props?.monthOf, props?.yearOf);
    const dueDate = getDateString(props?.dueDate);
    const amountDue = props?.amountDue;
    return (
        <div className={styles.container}>
            <div className={styles.desciption}>
                <div>
                    <p className={`${styles.status} ${styles.paid}`}>{status}</p>
                    <p className={styles.date}>{statementDate}</p>
                    <p className={styles.date}><b>Due Date: </b>{dueDate}</p>
                </div>
                <div>
                    <p className={styles.amount_due}>Total Amount Due</p>
                    <p className={styles.amount}>{amountDue}</p>
                </div>
            </div>
            <Link href={'/'}>
                <p className={styles.view}>View Details</p>
            </Link>
            <div className={styles.btn_container}>
                <button className={styles.btn_pdf}>SOA PDF</button>
                <button className={styles.pay_now}>PAY NOW</button>
            </div>
        </div>
    )
}

export default SoaCard