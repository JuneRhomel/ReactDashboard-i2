import Section from "@/components/general/section/Section";
import Layout from "@/components/layouts/layout";
import { useUserContext } from "@/context/userContext";
import { SoaPaymentsType, SoaType, UserType } from "@/types/models";
import { useEffect } from "react";

export default function Dashboard({authorizedUser, currentSoa, soaDetails}: {authorizedUser: UserType, currentSoa: SoaType, soaDetails: SoaPaymentsType[]}) {
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
    
    const paymentTransactionsProps = {
    title: 'Payment Transactions',
    headerAction: "Show All",
    data: first4SoaDetails,
    };

    const serviceRequestProps = {
        title: 'Service Requests',
        headerAction: null,
    }
    
    return (
    <Layout title="Dashboard" >
        <Section props={soaProps}></Section>
        <Section props={paymentTransactionsProps} />
        <Section props={serviceRequestProps}/>
    </Layout>
    )
}