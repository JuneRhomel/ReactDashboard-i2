import Link from 'next/link';
import styles from './MyrequestCard.module.css'

function MyrequestCard({ request }: { request: any }) {
    console.log(request);
    return (
        <Link href={request.link}>
            <div className={styles.card}>
                <img src={request.img} alt="" />
                <b>{request.title}</b>
            </div>
        </Link>
    )
}

export default MyrequestCard