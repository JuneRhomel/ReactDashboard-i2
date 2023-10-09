import Layout from "@/components/layouts/layout";
import PaymentCards from "@/components/pages/soa/PaymentCards";
import SoaCard from "@/components/pages/soa/SoaCard";
import { User } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";

export function getServerSideProps(context: any) {
  // Do the stuff to check if user is authenticated
  const token: string = context.req.cookies.token;
  const user = authorizeUser(token);
  
  return user
    ? {props: {user}}
    : { redirect: {destination: '/?error=accessDenied', permanent: false} };
}

export default function Dashboard({ user }: { user: any }) {
  // if data == authorized return the dashboard
  // else redirect to login
  return (
    <Layout title="Dashboard" >
      <div>{JSON.stringify(user)}</div>
      <h3>SOA</h3>
      <SoaCard/>
      <PaymentCards/>
    </Layout>
  )
}
