import { Dispatch, SetStateAction, useState } from 'react';
import styles from './CreateServiceRequestForm.module.css';
import { FaCaretDown, FaCaretUp } from "react-icons/fa6";
import CreateGatepassForm from '../createGatepassForm/CreateGatepassForm';
import { CreateGatepassFormType } from '@/types/models';

export default function CreateServiceRequestForm({type, handleInput, formData, setFormData, onSubmit}: {
    type: string,
    handleInput: Function,
    formData: CreateGatepassFormType,
    setFormData: Dispatch<SetStateAction<CreateGatepassFormType>>,
    onSubmit: Function,
    }){
    const [isOpen, setIsOpen] = useState(false);

    const handleClick = () => {
        setIsOpen(!isOpen);
    }

    const closeDropdown = () => {
        setIsOpen(false);
    }

    const formToRender = type === 'gatepass' ?
        <CreateGatepassForm
            closeDropdown={closeDropdown}
            handleInput={handleInput}
            formData={formData}
            setFormData={setFormData}
            onSubmit={onSubmit}
        /> : <></>
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