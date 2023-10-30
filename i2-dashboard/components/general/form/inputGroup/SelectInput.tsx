import { GatepassTypeType, InputProps } from "@/types/models";
import style from './InputGroup.module.css'
import { FaCaretDown } from "react-icons/fa6";
import { ChangeEventHandler } from "react";

export default function SelectInput({props, onChange}: {props: InputProps, onChange: ChangeEventHandler}) {

    return (
        <>
            <select name={props.name} id={props.name} className={style.select} onChange={onChange}>
                {/* <option value={undefined} disabled selected></option> */}
                {props.options?.map((option: GatepassTypeType, index) => (
                    <option key={index} value={option.id}>{option.categoryName}</option>
                ))}
            </select>
            <FaCaretDown className={style.selectCaret}/>
        </>
    )
}