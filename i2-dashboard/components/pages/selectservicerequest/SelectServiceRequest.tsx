import Layout from '@/components/layouts/layout';
import styles from "./SelectServiceRequest.module.css"
import { ServiceRequestsThumbnailData, UserType } from '@/types/models';
import Section from '@/components/general/section/Section';
import { useUserContext } from '@/context/userContext';

const SelectServiceRequest = ({authorizedUser}: {authorizedUser: UserType}) => {
    const {user, setUser} = useUserContext();
    setUser(authorizedUser);
    const thumbnailData: ServiceRequestsThumbnailData[] = [
        {
            title: "Gate Pass",
            img: '/gatepass.png',
            link: '/gatepass'
        },
        {
            title: "Visitor Pass",
            img: '/visitorspass.png',
            link: '/visitorpass'
        },
        {
            title: "Work Permit",
            img: '/workpermit.png',
            link: '/'
        },
        {
            title: "Report Issue",
            img: '/reportissue.png',
            link: '/reportissue'
        }
    ]

    const props = {
        title: 'select service request',
        headerAction: null,
        data: thumbnailData,
    }

    return (
        <Layout title="i2 - Service Requests">
                <Section props={props}/>
        </Layout>
    );
}

export default SelectServiceRequest;