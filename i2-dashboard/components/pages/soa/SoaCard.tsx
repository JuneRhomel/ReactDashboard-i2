import api from '@/utils/api'
import styles from './SoaCard.module.css'
import Link from 'next/link'
const SoaCard = () => {
    const fetchSoa = async () => {
        const response = await api.soa.getSoaDetails(
            {accountcode:"adminmailinatorcom", soaId: 842, limit: 50},
            "00ceb48bad1faa2c8cb0afe48aca18ac:tenant"
        );
        const statements = await response.json();

    }


    return (
        <div className={styles.container}>
            <div className={styles.desciption}>
                <div>
                    <p className={`${styles.status} ${styles.paid}`}>Paid</p>
                    <p className={styles.date}>September 2023</p>
                    <p className={styles.date}><b>Due Date:</b> Oct 12, 2023</p>
                </div>
                <div>
                    <p className={styles.amount_due}>Total Amount Due</p>
                    <p className={styles.amount}>27,128.00</p>
                </div>
            </div>
            <Link href={'/'}>
                <p className={styles.view}>View Details</p>
            </Link>
            <div className={styles.btn_container}>
                <button onClick={fetchSoa} className={styles.btn_pdf}>SOA PDF</button>
                <button className={styles.pay_now}>PAY NOW</button>
            </div>
        </div>
    )
}

export default SoaCard