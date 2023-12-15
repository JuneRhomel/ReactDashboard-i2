import { NewsAnnouncementsType } from '@/types/models';
import { NewsAnnouncementsCard } from '../../cards/newsAnnouncementsCard/NewsAnnouncementsCard'
import style from './NewsAnnouncements.module.css'
const newsAnnouncements = ({newsAnnouncements}: {newsAnnouncements: NewsAnnouncementsType[]}) => {
    return (
        <div className={style.displayArea}>
        {newsAnnouncements.map((announcement, index) => (<NewsAnnouncementsCard key={index} newsAnnouncement={announcement} />))}
        </div>
    )
}

export default newsAnnouncements