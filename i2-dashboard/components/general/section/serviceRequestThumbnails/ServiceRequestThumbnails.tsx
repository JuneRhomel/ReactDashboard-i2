import { ServiceRequestsThumbnailData } from '@/types/models';
import Thumbnail from '../../thumbnail/Thumbnail';
import styles from './ServiceRequestThumbnails.module.css';

const ServiceRequestThumbnails = () => {
    const thumbnailData: ServiceRequestsThumbnailData[] = [
        {
            title: "Gate Pass",
            img: '/gatepass.png',
            link: '/gatepass'
        },
        {
            title: "Visitor Pass",
            img: '/visitorspass.png',
            link: '/visitorpass'
        },
        {
            title: "Work Permit",
            img: '/workpermit.png',
            link: '/'
        },
        {
            title: "Report Issue",
            img: '/reportissue.png',
            link: '/reportissue'
        }
    ]
    return (
        <div className={styles.container}>
            {thumbnailData.map((thumbnail, index) => (<Thumbnail key={index} data={thumbnail}/>))}
        </div>
    )
}

export default ServiceRequestThumbnails