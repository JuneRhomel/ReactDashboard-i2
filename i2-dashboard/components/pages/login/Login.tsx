import styles from './Login.module.css';
import Layout from '@/components/layouts/layout';
import {FaExclamationCircle} from 'react-icons/fa';
import {BsEyeSlash, BsEyeFill} from 'react-icons/bs';
import apiSend from '@/pages/apiFetch';
import Header from "./Header"
import { useState, useRef, RefObject } from 'react';
import api from '@/utils/api';


const pageTitle: string = "Welcome to i2";

export default function Login() {
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

  const handleInput = (event: any) => {
    const value: string = event.target.value;
    const name: string = event.target.name;
    setFormData({...formData, [name]: value})
  }

  const toggleShowPassword = (event: any) => {
    event.preventDefault();
    setShowPassword(!showPassword);
  }

  const handleSubmit = async (event: any) => {
    event.preventDefault();

    const password = (document.getElementById("password") as HTMLInputElement).value;
    const email = (document.getElementById("email") as HTMLInputElement).value;

    const params = {
        email: "admin@mailinator.com",
        password: "12345",
        accountcode: "adminmailinatorcom",
    }

    console.log(api.user.authenticate(params));
    // console.log(emailRef.current?.validity);
  }

  return (
    // The Layout defines the page title and sets the favicon
    <Layout title={"Welcome to i2"}>
      <Header />

      {/* This is the main body of the login page. */}
      <form className={styles.loginForm} onSubmit={handleSubmit}>
        {/* Form Header is one div */}
        <div className={styles.formHeader}>
          <h2 className={styles.formGreeting}>Welcome to I2</h2>
          <h3 className={styles.formTitle}>
            Sign in to your account
            <span className={styles.faIcon}>
              <FaExclamationCircle style={iconStyle} />
            </span>
          </h3>
        </div>
        <div 
          className={styles.formInputGroup}
          onClick={() => {
            document.getElementById("email")?.focus();
          }}  
        >
          <label htmlFor="email" className={styles.inputLabel}>Email Address</label>
          <input
            id="email"
            type="email"
            name="email"
            className={styles.inputField}
            onChange={handleInput}
            value={formData.email}
          />
        </div>
        <div 
          className={styles.formInputGroup}
          onClick={() => {
            document.getElementById("password")?.focus();
          }}
        >
          <label htmlFor="password" className={styles.inputLabel}>Password</label>
          <div className={styles.passwordInput}>
            <input
              id="password"
              type={showPassword ? "text" : "password"}
              name="password"
              className={styles.inputField}
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