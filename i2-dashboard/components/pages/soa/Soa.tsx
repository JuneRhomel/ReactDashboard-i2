import Layout from "@/components/layouts/layout"
import SoaCard from "./SoaCard"
import PaymentCards from "./PaymentCards"
import style from "./Soa.module.css"

const Soa = () => {
    return (
        <Layout>
            <div>
                <h1 className={style.title}>SOA</h1>
                <SoaCard />
                <PaymentCards />
            </div>
        </Layout>
    )
}

export default Soa