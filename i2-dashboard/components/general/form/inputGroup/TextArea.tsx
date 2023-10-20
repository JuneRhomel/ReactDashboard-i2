import { InputProps } from '@/types/models'
import styles from './InputGroup.module.css'
export default function TextArea({props}: {props: InputProps}) {

    return (
        <textarea className={styles.textArea} name={props.name} value={props.value} id={props.name} onChange={props.onChange}/>
    )
}