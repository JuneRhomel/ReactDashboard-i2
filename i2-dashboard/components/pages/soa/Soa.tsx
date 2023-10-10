import Layout from "@/components/layouts/layout"
import style from "./Soa.module.css"
import { SoaDetailsType, SoaType } from "@/types/models"
import Section from "@/components/general/section/Section"

const Soa = ({currentSoa, soaDetails} : {
    currentSoa: SoaType,
    soaDetails: SoaDetailsType
}) => {
    const soaProps = {
        title: 'SOA',
        headerAction: null,
        data: currentSoa,
    }
    const paymentTransactionsProps = {
        title: 'Payment Transactions',
        headerAction: 'Show All',
        data: soaDetails,
    }
    return (
        <Layout title="i2 - SOA">
            <Section props={soaProps}/>
            <Section props={paymentTransactionsProps}/>
        </Layout>
    )
}

export default Soa