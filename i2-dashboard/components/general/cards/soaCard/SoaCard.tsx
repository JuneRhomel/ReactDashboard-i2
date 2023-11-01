import styles from './SoaCard.module.css'
import Link from 'next/link'
import getDateString from '@/utils/getDateString';
import { SoaPaymentsType, SoaType } from '@/types/models';
import formatCurrency from '@/utils/formatCurrency';
import SoaButtons from '../../button/SoaButtons';
const SoaCard = ({ currentSoa, currentSoaPayments }: { currentSoa: SoaType, currentSoaPayments: SoaPaymentsType[] }) => {
    const status = currentSoa.status;
    const statementDate = getDateString(null, parseInt(currentSoa.monthOf), parseInt(currentSoa.yearOf));
    const dueDate = getDateString(currentSoa?.dueDate);
    const statementAmount = parseFloat(currentSoa.amountDue);
    const credits = currentSoaPayments
        .filter((detail) => detail.particular.includes('SOA Payment') && detail.status !== 'Invalid')
        .map((detail) => detail.amount);
    const totalCredits = credits.reduce((total, amount) => total + parseFloat(amount), 0);
    const amountDue = formatCurrency(statementAmount - totalCredits);
    const statusClass = status === 'Paid' ? `${styles.status} ${styles.paid}` : `${styles.status} ${styles.unpaid}`;
    return (
        <div className={styles.container}>
            <div className={styles.desciption}>
                <div>
                    <p className={statusClass}>{status}</p>
                    <p className={styles.date}>{statementDate}</p>
                    <p className={styles.date}><b>Due Date: </b>{dueDate}</p>
                </div>
                <div>
                    <p className={styles.amountDue}>Total Amount Due</p>
                    <p className={styles.amount}>{amountDue}</p>
                </div>
            </div>
            <Link className={styles.viewDetails} href={`/viewsoa?id=${currentSoa.encId}`}>
                <p>View Details</p>
            </Link>
            <SoaButtons payAction={()=>{}}/>
        </div>
    )
}

export default SoaCard