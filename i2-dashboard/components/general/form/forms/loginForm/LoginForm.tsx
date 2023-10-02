import styles from './LoginForm.module.css';
import {FaExclamationCircle} from 'react-icons/fa';
import api from '@/utils/api';
import { useState } from 'react';
import InputGroup from '../../inputGroup/InputGroup';

const iconStyle: object = {
  color: "#1C5196",
  margin: "auto",
}



const LoginForm = () => {
    const [formData, setFormData] = useState({email: '', password: ''});


    const handleInput = (event: any) => {
        const value: string = event.target.value;
        const name: string = event.target.name;
        setFormData({...formData, [name]: value})
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
            
            <InputGroup name='email' label='Email Address' type='email' handleInput={handleInput} formData={formData}/>
            <InputGroup name='password' label='Password' type='password' handleInput={handleInput} formData={formData}/>

            <button className={styles.submitButton} type="submit">Submit</button>
        </form>
    )
}

export default LoginForm