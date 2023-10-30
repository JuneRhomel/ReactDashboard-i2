import { FaChevronLeft } from "react-icons/fa6";
import styles from './Button.module.css'

export default function Button({type, onClick}: {type: string, onClick: any}) {

    const buttonContent = new Map<string, any>([
        ['back', <FaChevronLeft key={'faChevronLeftKey'}/>],
        ['addItem', '+ Add Item'],
        ['addGuest', '+ Add Guest'],
        ['submit', 'Submit'],
        ['cancel', 'Cancel'],
    ])

    // const inputType = new Map<string, JSX.Element>([['pass', <PasswordInput props={props}/> ], ['2', <PasswordInput props={props}/>]])

    // const toDiplay = buttonContentMap[type] ? buttonContentMap[type] : 'No Button Yet';
    const toDisplay = buttonContent.get(type) ? buttonContent.get(type) : "No Button Yet";
    const buttonClassName = styles[type]

    return (
        <button onClick={onClick} className={`${styles.button} ${buttonClassName}`}>{toDisplay}</button>
    )
}