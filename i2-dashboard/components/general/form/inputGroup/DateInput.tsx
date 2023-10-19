import { InputProps } from "@/types/models";
import styles from './InputGroup.module.css';

export default function DateInput({props}: {props: InputProps}) {

    return (
        <>
            <input type="date" className={styles.dateInput} name={props.name} id={props.name} value={props.value} onChange={props.onChange}/>
        </>
    )
}