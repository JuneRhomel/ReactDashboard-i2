import { FaChevronLeft } from "react-icons/fa6";
import styles from './Button.module.css'

export default function Button({type, onClick}: {type: string, onClick: any}) {

    const buttonContent = new Map<string, any>([
        ['back', <FaChevronLeft key={'faChevronLeftKey'}/>],
        ['Item Details', '+ Add Item'],
        ['Guest List', '+ Add Guest'],
        ['List of Workers/Personnel', '+ Add Workers/Personnel'],
        ['List of Materials', '+ Add Materials'],
        ['List of Tools', '+ Add Tools'],
        ['submit', 'Submit'],
        ['cancel', 'Cancel'],
        ['logout', 'Logout'],
    ])

    // const inputType = new Map<string, JSX.Element>([['pass', <PasswordInput props={props}/> ], ['2', <PasswordInput props={props}/>]])

    // const toDiplay = buttonContentMap[type] ? buttonContentMap[type] : 'No Button Yet';
    const toDisplay = buttonContent.get(type) ? buttonContent.get(type) : "No Button Yet";
    const buttonClassName = typeof toDisplay === 'string' && toDisplay[0] === '+' ? styles.addItem : styles[type]

    return (
        <button onClick={onClick} className={`${styles.button} ${buttonClassName}`}>{toDisplay}</button>
    )
}