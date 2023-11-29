import Section from "@/components/general/section/Section";
import Layout from "@/components/layouts/layout";
import { useUserContext } from "@/context/userContext";
import { SoaPaymentsType, SoaType, UserType, SystemType, NewsType } from "@/types/models";
import { useEffect } from "react";

export default function Dashboard({authorizedUser, currentSoa, soaDetails, systemInfo, news}: {authorizedUser: UserType, currentSoa: SoaType, soaDetails: SoaPaymentsType[], systemInfo:SystemType[], news: NewsType[]}) {
    const first4SoaDetails = soaDetails !== null ? soaDetails.slice(0,4) : null;
    const {user, setUser} = useUserContext();

    useEffect(() => {
        setUser(authorizedUser);
    }, [])

    const soaProps = {
        title: 'SOA',
        headerAction: null,
        data: {currentSoa, soaDetails},
    }
    const systemInfoProps = {
        title: 'Banner',
        headerAction: null,
        data: {systemInfo,authorizedUser},
    }
    const paymentTransactionsProps = {
    title: 'Payment Transactions',
    headerAction: "Show All",
    data: first4SoaDetails,
    };

    const serviceRequestProps = {
        title: 'Service Requests',
        headerAction: null,
    }
    const newsAnnouncementsProps = {
        title: 'News',
        headerAction: null,
        data: news
    }
    return (
    <Layout title="Dashboard" >
        <Section props={systemInfoProps}></Section>
        <Section props={soaProps}></Section>
        <Section props={paymentTransactionsProps} />
        <Section props={serviceRequestProps}/>
    </Layout>
    )
}