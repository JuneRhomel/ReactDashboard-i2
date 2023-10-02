import styles from "./InputGroup.module.css"
import {BsEyeSlash, BsEyeFill} from 'react-icons/bs';
import { useState } from "react";

const eyeIconStyle: object = {
    all: "unset",
    color: "#c6c6c6",
    fontSize: "20px",
    transition: "300ms ease all",
  }

const InputGroup = ({name, label, type, handleInput, formData}: {name: string, label: string, type: 'text' | 'password' | 'email' | 'date', handleInput: any, formData: any}) => {
    const [showPassword, setShowPassword] = useState(false);

    const toggleShowPassword = (event: any) => {
        event.preventDefault();
        setShowPassword(!showPassword);
    }

    return (
        <div 
            className={styles.formInputGroup}
            onClick={() => {document.getElementById(name)?.focus();}}  
        >
            <label htmlFor={name} className={styles.inputLabel}>{label}</label>
            {type === 'password' ?
            <div className={styles.passwordInput}>
                <input
                    id={name}
                    type={showPassword ? 'text' : 'password'}
                    name={name}
                    className={styles.inputField}
                    onChange={handleInput}
                    value={formData[name]}
                />
                <button style={eyeIconStyle} onClick={toggleShowPassword}>{showPassword ? (<BsEyeFill/>) : (<BsEyeSlash/>)}
                </button>
            </div>
            : 
            <input
                id={name}
                type={type}
                name={name}
                className={styles.inputField}
                onChange={handleInput}
                value={formData[name]}
            />
            }
        </div>
    )
}

export default InputGroup