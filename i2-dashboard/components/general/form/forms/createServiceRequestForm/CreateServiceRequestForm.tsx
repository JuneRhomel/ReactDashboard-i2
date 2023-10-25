import { useState } from 'react';
import styles from './CreateServiceRequestForm.module.css';
import { FaCaretDown, FaCaretUp } from "react-icons/fa6";
import CreateGatepassForm from '../createGatepassForm/CreateGatepassForm';

export default function CreateServiceRequestForm({type}: {type: string}){
    const [isOpen, setIsOpen] = useState(false);

    const handleClick = () => {
        setIsOpen(!isOpen);
    }

    const closeDropdown = () => {
        setIsOpen(false);
    }

    const formToRender = type === 'Gate Pass' ? <CreateGatepassForm closeDropdown={closeDropdown}/> : <></>
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