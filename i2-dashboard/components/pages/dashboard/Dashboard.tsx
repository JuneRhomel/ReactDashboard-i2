import Section from "@/components/general/section/Section";
import Layout from "@/components/layouts/layout";
import { SoaDetailsType, SoaType } from "@/types/models";

export default function Dashboard({soa, soaDetails}: {soa: SoaType, soaDetails: SoaDetailsType}) {
    const soaProps = {
        title: 'SOA',
        headerAction: null,
        data: soa,
      }
    
    const paymentTransactionsProps = {
    title: 'Payment Transactions',
    headerAction: "Show All",
    data: soaDetails,
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