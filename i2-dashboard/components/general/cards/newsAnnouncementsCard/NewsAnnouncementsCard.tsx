
import { NewsAnnouncementsType } from "@/types/models";
import { useRouter } from "next/router";
import style from './NewsAnnouncementsCard.module.css'
export const NewsAnnouncementsCard = ({ newsAnnouncement }: { newsAnnouncement: NewsAnnouncementsType }) => {
    const router = useRouter();
    const { thumbnail, title , date} = newsAnnouncement;
    return (
      <div className={style.card}>
          <img className={style.image} src={thumbnail} alt="" />
        <div className={style.description}>
          <p className={style.title}>{title}</p>
          <p className={style.date}>{date}</p>
        </div>
      </div>
    );
  }