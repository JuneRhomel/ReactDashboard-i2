import SelectServiceRequest from "@/components/pages/selectservicerequest/SelectServiceRequest";
import authorizeUser from "@/utils/authorizeUser";

export const getServerSideProps = (context: any) => {
    const jwt = context.req.cookies.token;
    const user = authorizeUser(jwt);
    if (!user) {
        return {redirect : {destination: '/?error=accessDenied', permanent: false}};
    }
    return {
        props: {authorizedUser: user}
    }
}

export default SelectServiceRequest