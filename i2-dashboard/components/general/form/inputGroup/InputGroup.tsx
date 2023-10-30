import styles from "./InputGroup.module.css"
import { InputProps } from "@/types/models";
import PasswordInput from "./PasswordInput";
import StandardInput from "./StandardInput";
import SelectInput from "./SelectInput";
import DateInput from "./DateInput";
import TextArea from "./TextArea";
import { ChangeEventHandler } from "react";

const InputGroup = ({props, onChange}: {props: InputProps, onChange: ChangeEventHandler}) => {
    // const inputType = new Map<string, JSX.Element>([['pass', <PasswordInput props={props}/> ], ['2', <PasswordInput props={props}/>]])
    // Use this kind of map instead
    const inputTypeMap: {[key: string]: JSX.Element} = {
        password: <PasswordInput props={props} onChange={onChange}/>,
        select: <SelectInput props={props} onChange={onChange}/>,
        textArea: <TextArea props={props} onChange={onChange}/>,
    }

    const inputToRender = inputTypeMap[props.type] ? inputTypeMap[props.type] : <StandardInput props={props} onChange={onChange}/>;


    const inputGroupClassName = props.disabled ? `${styles.formInputGroup} ${styles.disabled}` : `${styles.formInputGroup}`;
    return (
        <div 
            className={inputGroupClassName}
            onClick={() => {document.getElementById(props.name)?.click();}}
        >
            <label htmlFor={props.name} className={styles.inputLabel}>
                {props.label}
                {props.required ? <span className={styles.required}> *</span> : <></>}
            </label>
            {inputToRender}

        </div>
    )
}

export default InputGroup