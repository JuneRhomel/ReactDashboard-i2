import Layout from "@/components/layouts/layout"
import SoaCard from "./SoaCard"
import PaymentCards from "./PaymentCards"
import style from "./Soa.module.css"
import { SoaType } from "@/types/models"
import Section from "@/components/general/Section"

const Soa = ({currentSoa}: {currentSoa: SoaType}) => {
    const props = {
        title: 'SOA',
        headerAction: null,
        data: currentSoa,
    }
    return (
        <Layout title="i2 - SOA">
            <Section props={props}/>
            <div>
                <PaymentCards />
            </div>
        </Layout>
    )
}

export default Soa