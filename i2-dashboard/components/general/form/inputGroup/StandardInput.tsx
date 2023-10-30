import { InputProps } from "@/types/models";
import styles from './InputGroup.module.css';
import { ChangeEventHandler } from "react";

export default function StandardInput({props, onChange}: {props: InputProps, onChange: ChangeEventHandler}) {

    return (
        <input
            className={styles.inputField}
            id={props.name}
            type={props.type}
            name={props.name}
            onChange={onChange}
            value={props.value}
            required={props.required}
            disabled={props.disabled}
        />
    )
}
