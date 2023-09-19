import Layout from '../components/layouts/layout';
import Login from "./login";
import Navigation from '@/components/layouts/navigation/Navigation';

const pageTitle: string = "Welcome to Inventi I2";

export default function Home() {
  return (
    <>
      <Layout>
        <Login />
        <Navigation />
      </Layout>
    </>

  )
}
