import Layout from "@/components/layouts/layout"
import style from "./Soa.module.css"
import { SoaType } from "@/types/models"
import Section from "@/components/general/section/Section"

const Soa = ({currentSoa}: {currentSoa: SoaType}) => {
    const soaProps = {
        title: 'SOA',
        headerAction: null,
        data: currentSoa,
    }
    const paymentTransactionsProps = {
        title: 'Payment Transactions',
        headerAction: 'Show All',
    }
    return (
        <Layout title="i2 - SOA">
            <Section props={soaProps}/>
            <Section props={paymentTransactionsProps}/>
        </Layout>
    )
}

export default Soa