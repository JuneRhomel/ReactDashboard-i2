import Layout from "@/components/layouts/layout"
import style from "./MyRequest.module.css"
import { MdAdd } from "react-icons/md"
import RequestCard from "./RequestCard"
import Link from "next/link"
function MyRequest() {
    return (
        <Layout title="My Request">
            <div className={style.header}>
                <h2 className="title-section">My Request</h2>
                <Link href='/' className="main-btn">
                    <MdAdd />
                    Create New 
                </Link>
            </div>
            <div className={style.cards}>
                <RequestCard/>
                <RequestCard/>
                <RequestCard/>
            </div>
        </Layout>
    )
}

export default MyRequest