import Layout from "@/components/layouts/layout";
import PaymentCards from "@/components/pages/soa/PaymentCards";
import SoaCard from "@/components/pages/soa/SoaCard";
import { UserType } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";
import Section from "@/components/general/Section";

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
  return (
    <Layout title="Dashboard" >
        <Section props={props}></Section>
        <PaymentCards/>
    </Layout>
  )
}
