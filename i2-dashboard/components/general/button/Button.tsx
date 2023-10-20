import { FaChevronLeft } from "react-icons/fa6";
import styles from './Button.module.css'
import { NextRouter, useRouter } from "next/router";

export default function Button({type, onClick}: {type: string, onClick: any}) {
    const buttonContentMap: any = {
        'back': <FaChevronLeft/>,
        'addItem': '+ Add Item',
    }
    const toDiplay = buttonContentMap[type] ? buttonContentMap[type] : 'No Button Yet';
    const buttonClassName = styles[type]

    return (
        <button onClick={onClick} className={`${styles.button} ${buttonClassName}`}>{toDiplay}</button>
    )
}