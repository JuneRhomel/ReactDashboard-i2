import { InputProps } from '@/types/models'
import styles from './InputGroup.module.css'
import { ChangeEventHandler } from 'react'
export default function TextArea({props, onChange}: {props: InputProps, onChange: ChangeEventHandler}) {

    return (
        <textarea className={styles.textArea} name={props.name} value={props.value} id={props.name} onChange={onChange}/>
    )
}