import Layout from "@/components/layouts/layout"
import style from "./MyRequest.module.css"
import { MdAdd } from "react-icons/md"
import RequestCard from "../../general/cards/requestCard/RequestCard"
import Link from "next/link"
import { RequestType } from "@/types/models"
import Section from "@/components/general/section/Section"

const MyRequest = ({ myRequest }: {
    myRequest: RequestType,
}) => {
    console.log(myRequest);
    const requestProps = {
        title: 'My Request',
        headerAction:
            <Link href='/servicerequest' className="main-btn">
                <MdAdd />
                Create New
            </Link>,
        data: myRequest,
    }
    return (
        <Layout title="My Request">
            <Section props={requestProps} />
        </Layout>
    );
}

export default MyRequest