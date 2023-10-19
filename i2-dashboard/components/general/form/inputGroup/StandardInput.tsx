import { InputProps } from "@/types/models";
import styles from './InputGroup.module.css';

export default function StandardInput({props}: {props: InputProps}) {

    return (
        <input
            className={styles.inputField}
            id={props.name}
            type={props.type}
            name={props.name}
            onChange={props.onChange}
            value={props.value}
            required={props.required}
            disabled={props.disabled}
        />
    )
}
