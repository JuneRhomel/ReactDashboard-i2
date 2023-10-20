import { useState } from 'react';
import styles from './CreateServiceRequestForm.module.css';
import { FaCaretDown, FaCaretUp } from "react-icons/fa6";
import CreateGatePassForm from '../createGatePassForm/CreateGatePassForm';

export default function CreateServiceRequestForm({type}: {type: string}){
    const [isOpen, setIsOpen] = useState(true);

    const handleClick = () => {
        setIsOpen(!isOpen);
    }

    const formToRender = type === 'Gate Pass' ? <CreateGatePassForm/> : <></>
    const contentStyle = isOpen ? `${styles.content} ${styles.show}` : `${styles.content} ${styles.hidden}`;
    const dropdownHeaderIcon = isOpen ? <FaCaretUp/> : <FaCaretDown/>;
    
    return (
        <div className={styles.dropdown}>
            <div className={styles.header} onClick={handleClick}>
                <div className={styles.title}>Request Form</div>
                {dropdownHeaderIcon}
            </div>
            <div className={contentStyle}>
                {formToRender}
            </div>
        </div>
    )
}