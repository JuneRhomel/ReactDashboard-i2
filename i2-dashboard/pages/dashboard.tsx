import Layout from "@/components/layouts/layout";
import PaymentTransactions from "@/components/general/section/paymentTransactions/PaymentTransactions";
import { UserType } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";
import Section from "@/components/general/section/Section";

export function getServerSideProps(context: any) {
  // Do the stuff to check if user is authenticated
  const token: string = context.req.cookies.token;
  const user = authorizeUser(token);
  
  return user
    ? {props: {user}}
    : { redirect: {destination: '/?error=accessDenied', permanent: false} };
}

export default function Dashboard({ user }: { user: UserType }) {
  // else redirect to login
  const props = {
    title: 'SOA',
    headerAction: null,
  }

  const paymentTransactionsProps = {... props, title: 'Payment Transactions'};
  return (
    <Layout title="Dashboard" >
        <Section props={props}></Section>
        <Section props={paymentTransactionsProps} />
    </Layout>
  )
}
