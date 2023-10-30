import { InputProps } from "@/types/models";
import styles from './InputGroup.module.css';
import { ChangeEventHandler } from "react";

export default function DateInput({props, onChange}: {props: InputProps, onChange: ChangeEventHandler}) {

    return (
        <>
            <input type="date" className={styles.dateInput} name={props.name} id={props.name} value={props.value} onChange={onChange}/>
        </>
    )
}