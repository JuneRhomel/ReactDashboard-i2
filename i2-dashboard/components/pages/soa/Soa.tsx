import Layout from "@/components/layouts/layout"
import SoaCard from "./SoaCard"
import PaymentCards from "./PaymentCards"
import style from "./Soa.module.css"
import { SoaType } from "@/types/models"

const Soa = ({currentSoa}: {currentSoa: SoaType}) => {
    console.log(currentSoa.amountDue)
    return (
        <Layout title="SOA">
            <div>
                <h1 className={style.title}>SOA</h1>
                <SoaCard />
                <PaymentCards />
            </div>
        </Layout>
    )
}

export default Soa