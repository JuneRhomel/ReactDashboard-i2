import Layout from "@/components/layouts/layout"
import { MdAdd } from "react-icons/md"
import Link from "next/link"
import { ServiceRequestType, UserType } from "@/types/models"
import Section from "@/components/general/section/Section"
import { useUserContext } from "@/context/userContext"
import { useEffect } from "react"

type MyRequestProps = {
    authorizedUser: UserType,
    serviceRequests: ServiceRequestType[] | null,
    errors: any[] | null,
}

const MyRequest = ( {authorizedUser, serviceRequests, errors}: MyRequestProps ) => {
    const title = "i2 - My Requests"
    const {user, setUser} = useUserContext();
    useEffect(()=> {
        setUser(authorizedUser);
    }, [])
    if (errors) {
        return (
            <Layout title={title}>
                <h1>{errors}</h1>
            </Layout>
        )
    } else {
        const requestProps = {
            title: 'My Requests',
            headerAction:
                <Link href='/selectservicerequest' className="main-btn">
                    <MdAdd />
                    Create New
                </Link>,
            data: serviceRequests,
        }
        return (
            <Layout title={title}>
                <Section props={requestProps} />
            </Layout>
        );
    }
}

export default MyRequest