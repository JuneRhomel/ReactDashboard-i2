import Layout from "@/components/layouts/layout"
import { MdAdd } from "react-icons/md"
import Link from "next/link"
import { RequestType } from "@/types/models"
import Section from "@/components/general/section/Section"

const MyRequest = ( props: any ) => {
    const title = "i2 - My Requests"
    if (props.error) {
        return (
            <Layout title={title}>
                <h1>{props.error}</h1>
            </Layout>
        )
    } else {
        const requestProps = {
            title: 'My Requests',
            headerAction:
                <Link href='#' className="main-btn">
                    <MdAdd />
                    Create New
                </Link>,
            data: props.serviceRequests,
        }
        return (
            <Layout title={title}>
                <Section props={requestProps} />
            </Layout>
        );
    }
}

export default MyRequest