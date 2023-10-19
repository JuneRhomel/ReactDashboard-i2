import { FaChevronLeft } from "react-icons/fa6";
import styles from './Button.module.css'
import { NextRouter, useRouter } from "next/router";

export default function Button({type}: {type: string}) {
    const router: NextRouter = useRouter();
    const buttonContentMap: any = {
        'back': <FaChevronLeft/>,
    }
    const toDiplay = buttonContentMap[type] ? buttonContentMap[type] : 'No Button Yet';
    const buttonClassName = styles[type]

    const handleClick = () => {
        router.back();
    }
    return (
        <button onClick={handleClick} className={`${styles.button} ${buttonClassName}`}>{toDiplay}</button>
    )
}