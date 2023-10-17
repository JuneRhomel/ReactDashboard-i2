import { ServiceRequestsThumbnailData } from '@/types/models';
import styles from './Thumbnail.module.css';
import Link from 'next/link';

const Thumbnail = ({data} : {data : ServiceRequestsThumbnailData}) => {

    return (
        <Link href={data.link}>
            <div className={styles.card}>
                <img src={data.img} alt="" />
                <b>{data.title}</b>
            </div>
        </Link>
    )
}

export default Thumbnail;