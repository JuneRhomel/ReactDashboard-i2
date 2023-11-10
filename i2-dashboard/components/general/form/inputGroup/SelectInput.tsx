import { SelectDataType, InputProps } from "@/types/models";
import style from './InputGroup.module.css'
import { FaCaretDown } from "react-icons/fa6";
import { ChangeEventHandler } from "react";

export default function SelectInput({props, onChange}: {props: InputProps, onChange: ChangeEventHandler}) {
    return (
        <>
            <select name={props.name} id={props.name} className={style.select} onChange={onChange} defaultValue='0'>
                <option value={0} disabled></option>
                {props.options?.map((option: SelectDataType, index) => (
                    <option key={index} value={option.id}>{option.name}</option>
                ))}
            </select>
            <FaCaretDown className={style.selectCaret}/>
        </>
    )
}