import Layout from "@/components/layouts/layout"
import { MdAdd } from "react-icons/md"
import Link from "next/link"
import { NewsAnnouncementsType, UserType } from "@/types/models"
import Section from "@/components/general/section/Section"
import { useUserContext } from "@/context/userContext"
import { useEffect } from "react"

type MyNewsAnnouncementsProps = {
    authorizedUser: UserType,
    newsAnnouncements: NewsAnnouncementsType[] | null,
    errors: any[] | null,
}

const NewsAnnouncement = ( {authorizedUser, newsAnnouncements, errors}: MyNewsAnnouncementsProps ) => {
    const title = "i2 - News And Announcements"
    const {user, setUser} = useUserContext();
    useEffect(()=> {
        setUser(authorizedUser);
    }, [])
    
    const newsAnnouncementsProps = {
        title: "News Announcements",
        headerAction: null,
        data: newsAnnouncements,
      };
    if (errors) {
        return (
            <Layout title={title}>
                <h1>{errors}</h1>
            </Layout>
        )
    } else {

        return (
            <Layout title={title}>
                <Section props={newsAnnouncementsProps} />
            </Layout>
        );
    }
}

export default NewsAnnouncement