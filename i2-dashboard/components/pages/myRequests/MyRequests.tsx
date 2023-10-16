import Layout from "@/components/layouts/layout"
import { MdAdd } from "react-icons/md"
import Link from "next/link"
import { RequestType } from "@/types/models"
import Section from "@/components/general/section/Section"

const MyRequest = ({ myRequest }: {
    myRequest: RequestType,
}) => {
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