import { InputProps } from "@/types/models";
import style from './InputGroup.module.css'
import { FaCaretDown } from "react-icons/fa6";

export default function SelectInput({props}: {props: InputProps}) {

    return (
        <>
            <select name={props.name} id={props.name} className={style.select} onChange={props.onChange}>
                {/* <option value={undefined} disabled selected></option> */}
                {props.options?.map((option, index) => (
                    <option key={index} value={option}>{option}</option>
                ))}
            </select>
            <FaCaretDown className={style.selectCaret}/>
        </>
    )
}