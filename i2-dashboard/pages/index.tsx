import styles from '@/styles/Home.module.css';
import Layout from './layout';
import {FaExclamationCircle} from 'react-icons/fa';
import {BsEyeSlash, BsEyeFill} from 'react-icons/bs';
import { useState, useRef, RefObject } from 'react';


const pageTitle: string = "Welcome to i2";

export default function Home() {
  const emailRef = useRef<HTMLInputElement>(null);
  const passwordRef = useRef<HTMLInputElement>(null);
  const [formData, setFormData] = useState({email: '', password: ''});
  const [showPassword, setShowPassword] = useState(false);

  const iconStyle: object = {
    color: "#1C5196",
    margin: "auto",
  }

  const eyeIconStyle: object = {
    all: "unset",
    color: "#c6c6c6",
    fontSize: "20px",
    transition: "300ms ease all",
  }
  // const [inputBorder, setInputBorder] = useState<string>('#A8B5C2');

  const handleClick = (ref: RefObject<HTMLInputElement>) => {
    ref.current?.focus();
  }

  const handleInput = (event: any) => {
    const value: string = event.target.value;
    const name: string = event.target.name;
    setFormData({...formData, [name]: value})
  }

  const toggleShowPassword = (event: any) => {
    event.preventDefault();
    setShowPassword(!showPassword);
  }

  const handleSubmit = (event: any) => {
    event.preventDefault();
    console.log(emailRef.current?.validity);
  }

  return (
    // The Layout defines the page title and sets the favicon
    <Layout title={pageTitle}>
      <header className={styles.header}>
        <img className={styles.headerBackground} src="/background.png" alt="header background"/>
        <img className={styles.headerLogo} src="/logo.svg" alt="Inventi Logo White" />
      </header>

      {/* This is the main body of the login page. */}
      <form className={styles.loginForm} onSubmit={handleSubmit}>
        {/* Form Header is one div */}
        <div className={styles.formHeader}>
          <h2 className={styles.formGreeting}>Welcome to I2</h2>
          <h3 className={styles.formTitle}>
            Sign in to your account
            <span className={styles.faIcon}>
              <FaExclamationCircle style={iconStyle}/>
            </span>
          </h3>
        </div>

        <div className={styles.formInputGroup} onClick={()=>handleClick(emailRef)}>
          <label htmlFor="email" className={styles.inputLabel}>Email Address</label>
          <input
            type="email"
            name="email"
            className={styles.inputField}
            ref={emailRef}
            onChange={handleInput}
            value={formData.email}
          />
        </div>
        <div className={styles.formInputGroup} onClick={()=>handleClick(passwordRef)}>
          <label htmlFor="password" className={styles.inputLabel}>Password</label>
          <div className={styles.passwordInput}>
            <input
              type={showPassword ? "text" : "password"}
              name="password"
              className={styles.inputField}
              ref={passwordRef}
              onChange={handleInput}
              value={formData.password}
            />
            <button style={eyeIconStyle} onClick={toggleShowPassword}>
              {showPassword ? (<BsEyeFill/>) : (<BsEyeSlash/>)}
            </button>
          </div>
        </div>
        <button className={styles.submitButton} type="submit">Submit</button>
      </form>
    </Layout>
  )
}
