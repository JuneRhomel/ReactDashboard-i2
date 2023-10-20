import styles from "./InputGroup.module.css"
import { InputProps } from "@/types/models";
import PasswordInput from "./PasswordInput";
import StandardInput from "./StandardInput";
import SelectInput from "./SelectInput";
import DateInput from "./DateInput";
import TextArea from "./TextArea";

const InputGroup = ({props}: {props: InputProps}) => {
    // const inputType = new Map<string, JSX.Element>([['pass', <PasswordInput props={props}/> ], ['2', <PasswordInput props={props}/>]])
    // Use this kind of map instead
    const inputTypeMap: {[key: string]: JSX.Element} = {
        password: <PasswordInput props={props}/>,
        select: <SelectInput props={props} />,
        date: <DateInput props={props} />,
        textArea: <TextArea props={props}/>,
    }

    const inputToRender = inputTypeMap[props.type] ? inputTypeMap[props.type] : <StandardInput props={props}/>;


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