import styles from '@/styles/Home.module.css';
import Layout from './layout';
import {FaExclamationCircle} from 'react-icons/fa'

const pageTitle: string = "Welcome to i2";
const iconStyle = {
  color: "#1C5196",
}

export default function Home() {
  return (
    // The Layout defines the page title and sets the favicon
    <Layout title={pageTitle}>
      <header className={styles.header}>
        <img className={styles.headerBackground} src="/background.png" alt="header background"/>
        <img className={styles.headerLogo} src="/logo.svg" alt="Inventi Logo White" />
      </header>

      {/* This is the main body of the login page. */}
      <form className={styles.loginForm}>
        <h2 className={styles.formGreeting}>Hello</h2>
        <h3 className={styles.formTitle}>
          Sign in to your account
          <span className={styles.faIcon}>
            <FaExclamationCircle style={iconStyle}/>
          </span>
        </h3>
          <div className={styles.formInputGroup}>
            <label htmlFor="email" className={styles.inputLabel}>Email</label>
            <input type="email" name="email" className={styles.formInput} />
          </div>
          <div className={styles.formInputGroup}>
            <label htmlFor="password" className={styles.inputLabel}>Password</label>
            <input type="password" name="password" className={styles.formInput} />
          </div>
          <button className={styles.submitButton}>Submit</button>
      </form>
    </Layout>
  )
}
