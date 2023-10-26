import styles from './Login.module.css';
import Layout from '@/components/layouts/layout';
import Image from 'next/image';

import Header from "./Header"
import LoginForm from '@/components/general/form/forms/loginForm/LoginForm';

const pageTitle: string = "Welcome to i2";

export default function Login() {

  return (
    // The Layout defines the page title and sets the favicon
    <Layout title={pageTitle}>
      <Header />

      {/* This is the main body of the login page. */}
      <LoginForm />
      
      <Image className={styles.footerLogo} height={44} width={113} src="/navlogo1.png" alt="Powered by Inventi Logo"/>
    </Layout>
  )
}