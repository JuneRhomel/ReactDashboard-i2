import styles from './LoginForm.module.css';
import {FaExclamationCircle} from 'react-icons/fa';
import api from '@/utils/api';
import { useState } from 'react';
import InputGroup from '../../inputGroup/InputGroup';
import { NextRouter, useRouter } from 'next/router';

const iconStyle: object = {
  color: "#1C5196",
  margin: "auto",
}


const LoginForm = () => {
    const router: NextRouter = useRouter();
    const [formData, setFormData] = useState({email: '', password: ''});
    const [error, setError] = useState("");

    const handleInput = (event: any) => {
        const value: string = event.target.value;
        const name: string = event.target.name;
        setFormData({...formData, [name]: value})
        setError("");
    }
      
    const handleSubmit = async (event: any) => {
        event.preventDefault();
    
        const password = (document.getElementById("password") as HTMLInputElement).value;
        const email = (document.getElementById("email") as HTMLInputElement).value;
    
        const params = {
            email: "admin@mailinator.com",
            password: "12345",
            accountcode: "adminmailinatorcom",
            // accountcode: "UDEya0JuMWcyQjhKOHc3WVNwMWNQT1Rja2ozdkVyNWdjYWwxV21vNzNyWT0.7b6f916e21476e8c401e23b41150cf45",
        }
    
        const response: Response | string = await api.user.authenticate(params);
        console.log(response);
        if (response.ok) {
            router.push('/dashboard');
        } else {
            setError(response as unknown as string)
        }
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
            {/* Show the error message if there is one */}
            {error !== "" ? (<div>{error}</div>): null }
            <InputGroup name='email' label='Email Address' type='email' handleInput={handleInput} formData={formData}/>
            <InputGroup name='password' label='Password' type='password' handleInput={handleInput} formData={formData}/>

            <button className={styles.submitButton} type="submit">Submit</button>
        </form>
    )
}

export default LoginForm