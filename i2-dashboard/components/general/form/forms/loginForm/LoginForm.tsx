import styles from './LoginForm.module.css';
import {FaExclamationCircle} from 'react-icons/fa';
import api from '@/utils/api';
import { useState } from 'react';
import InputGroup from '../../inputGroup/InputGroup';
import { NextRouter, useRouter } from 'next/router';
import { InputProps, UserType } from '@/types/models';

const iconStyle: object = {
  color: "#1C5196",
  margin: "auto",
}
// {/* <InputGroup name='email' label='Email Address' type='email' handleInput={handleInput} formData={formData}/> */}
// {/* <InputGroup name='password' label='Password' type='password' handleInput={handleInput} formData={formData}/> */}

const LoginForm = () => {
    const router: NextRouter = useRouter();
    const [formData, setFormData] = useState({email: 'admin@mailinator.com', password: '12345'});
    const [error, setError] = useState("");

    const handleInput = (event: any) => {
        const value: string = event.target.value;
        const name: string = event.target.name;
        setFormData({...formData, [name]: value})
        setError("");
    }
      
    const handleSubmit = async (event: any) => {
        event.preventDefault();
    
        console.log('asd')
        const password = (document.getElementById("password") as HTMLInputElement).value;
        const email = (document.getElementById("email") as HTMLInputElement).value;
    
        const params = {
            email: email,
            password: password,
            accountcode: "adminmailinatorcom",
            // accountcode: "UDEya0JuMWcyQjhKOHc3WVNwMWNQT1Rja2ozdkVyNWdjYWwxV21vNzNyWT0.7b6f916e21476e8c401e23b41150cf45",
        }
    
        const response: Response | string = await api.user.authenticate(params);
        if (response.ok) {
            router.push('/dashboard');
        } else {
            setError(response as unknown as string)
        }
    }

    const props: { [key: string]: InputProps } = {
        emailInput: {
            name: 'email',
            label: 'Email Address',
            type: 'email',
            value: formData.email,
            required: true,
        },
        passwordInput: {
            name: 'password',
            label: 'Password',
            type: 'password',
            value: formData.password,
            required: true,
        }
    };


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
            <InputGroup props={props.emailInput} onChange={handleInput}/>
            <InputGroup props={props.passwordInput} onChange={handleInput}/>
            <button className={styles.submitButton} type="submit">Submit</button>
        </form>
    )
}

export default LoginForm

