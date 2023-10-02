import styles from './Login.module.css';
import Layout from '@/components/layouts/layout';

import Header from "./Header"
import { useState, useRef, RefObject } from 'react';
import api from '@/utils/api';
import Form from '@/components/general/form/Form';

const pageTitle: string = "Welcome to i2";

export default function Login() {

  return (
    // The Layout defines the page title and sets the favicon
    <Layout title={"Welcome to i2"}>
      <Header />

      {/* This is the main body of the login page. */}
      <Form type='login'/>
      
      <img className={styles.footerLogo} src="/navlogo1.png" alt="Powered by Inventi Logo" />
    </Layout>
  )
}