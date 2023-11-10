import Layout from "@/components/layouts/layout"
import style from "./Soa.module.css"
import { SoaPaymentsType, SoaType, UserType } from "@/types/models"
import Section from "@/components/general/section/Section"
import { useUserContext } from "@/context/userContext"

const Soa = ({authorizedUser, currentSoa, paymentTransactions, unpaidSoas, paidSoas} : {
    authorizedUser: UserType,
    currentSoa: SoaType,
    paymentTransactions: SoaPaymentsType[],
    unpaidSoas: SoaType[],
    paidSoas: SoaType[],
}) => {
    const {user, setUser} = useUserContext();
    setUser(authorizedUser);
    const soaDetails = paymentTransactions.filter((transaction: SoaPaymentsType) => {
        return transaction.soaId === currentSoa.id;
    })

    console.log(paidSoas)

    const firstTwoDetailsMap = paymentTransactions?.reduce((result, detail) => {
        if (!result[detail.soaId]) {
        result[detail.soaId] = [];
        }

        if (result[detail.soaId].length < 2) {
        result[detail.soaId].push(detail);
        }

        return result;
    }, {} as {[key: string]: SoaPaymentsType[]});

    const firstTwoPaymentTransactions =  firstTwoDetailsMap ? Object.values(firstTwoDetailsMap).flat() : undefined;
    firstTwoPaymentTransactions?.sort((a, b) => parseInt(b.id) - parseInt(a.id));

    const soaProps = {
        title: 'SOA',
        headerAction: null,
        data: {currentSoa, soaDetails},
    }
    const paymentTransactionsProps = {
        title: 'Payment Transactions',
        headerAction: 'Show All',
        data: firstTwoPaymentTransactions,
    }
    return (
        <Layout title="i2 - SOA">
            <Section props={soaProps}/>
            <Section props={paymentTransactionsProps}/>
        </Layout>
    )
}

export default Soa