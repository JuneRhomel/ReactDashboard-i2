import { InputProps } from "@/types/models";
import { useState } from "react";
import styles from './InputGroup.module.css';
import { BsEyeFill, BsEyeSlash } from "react-icons/bs";

const eyeIconStyle: object = {
    all: "unset",
    color: "#c6c6c6",
    fontSize: "20px",
    transition: "300ms ease all",
  }

export default function PasswordInput({props}: {props: InputProps}) {
    const [showPassword, setShowPassword] = useState(false);

    const toggleShowPassword = (event: any) => {
        event.preventDefault();
        setShowPassword(!showPassword);
    }

    return (
        <div className={styles.passwordInput}>
            <input
                id={props.name}
                type={showPassword ? 'text' : 'password'}
                name={props.name}
                className={styles.inputField}
                onChange={props.onChange}
                value={props.value}
                required={props.required}
            />
            <button style={eyeIconStyle} onClick={toggleShowPassword}>{showPassword ? (<BsEyeFill/>) : (<BsEyeSlash/>)}</button>
        </div>
    )
}