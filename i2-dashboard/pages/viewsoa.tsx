import ViewSoa from "@/components/pages/viewsoa/ViewSoa"
import { ParamGetSoaDetailsType, ParamGetSoaType } from "@/types/apiRequestParams";
import { SoaDetailsType, SoaPaymentsType, SoaType } from "@/types/models";
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";
import decryptData from "@/utils/decryptData";

export async function getServerSideProps(context: any) {
    const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
    const jwt = context.req.cookies.token;
    const user = authorizeUser(jwt);
    if (!user) {
        return {redirect : {destination: '/?error=accessDenied', permanent: false}};
    }
    const soaEncryptedId = context.query.id;
    if (!soaEncryptedId) {
        return {redirect : {destination: '/400?error=getParameterNotProvided'}}
    }
    const soaId = decryptData(soaEncryptedId);

    const getParams: ParamGetSoaType | ParamGetSoaDetailsType = {
        accountcode: accountCode,
        soaId: soaId
    }
    const getSoaPromise = api.soa.getSoa(getParams)
    const getSoaDetailsPromise = api.soa.getSoaDetails(getParams as ParamGetSoaDetailsType);
    const getSoaPaymentsPromise = api.soa.getSoaPayments(getParams as ParamGetSoaDetailsType);
    const [getSoaResponse, getSoaDetailsResponse, getSoaPaymentsResponse] = await Promise.all([getSoaPromise, getSoaDetailsPromise, getSoaPaymentsPromise]);
    const soa = getSoaResponse.success ? getSoaResponse.data?.pop() as SoaType : undefined
    const soaDetails = getSoaDetailsResponse.success ? getSoaDetailsResponse.data as SoaDetailsType[] : undefined
    const unfilteredSoaPayments = getSoaPaymentsResponse.success ? getSoaPaymentsResponse.data as SoaPaymentsType[] : undefined
    soaDetails?.sort((a, b) => parseInt(a.id) - parseInt(b.id));
    const soaPayments = unfilteredSoaPayments?.filter((payment) => {
        return !(payment.particular.includes("SOA Payment") && ['Successful', 'Invalid'].includes(payment.status)) && !payment.particular.includes("Balance");
    })
    if (soa && soaDetails && soaPayments) {
        return {
            props: {soa, soaDetails, soaPayments}
        }
    } else {
        return {
            props: {error: '400 Bad Request: Could not fetch SOA Details'}
        }
        // Handle error
    }
}

export default ViewSoa