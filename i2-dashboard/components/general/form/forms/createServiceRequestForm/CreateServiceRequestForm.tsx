import { Dispatch, SetStateAction, useState } from 'react';
import styles from './CreateServiceRequestForm.module.css';
import { FaCaretDown, FaCaretUp } from "react-icons/fa6";
import CreateGatepassForm from './createGatepassForm/CreateGatepassForm';
import { CreateGatepassFormType, CreateVisitorPassFormDataType } from '@/types/models';
import CreateVisitorPassForm from './createVisitorPassForm/CreateVisitorPassForm';

export default function CreateServiceRequestForm({type, handleInput, formData, setFormData, onSubmit}: {
    type: string,
    handleInput: Function,
    formData: CreateGatepassFormType | CreateVisitorPassFormDataType,
    setFormData: Dispatch<SetStateAction<CreateGatepassFormType | CreateVisitorPassFormDataType>>,
    onSubmit: Function,
    }){
    const [isOpen, setIsOpen] = useState(false);

    const handleClick = () => {
        setIsOpen(!isOpen);
    }

    const closeDropdown = () => {
        setIsOpen(false);
    }

    const gatepassForm = <CreateGatepassForm
        closeDropdown={closeDropdown}
        handleInput={handleInput}
        formData={formData as CreateGatepassFormType}
        setFormData={setFormData as Dispatch<SetStateAction<CreateGatepassFormType>>}
        onSubmit={onSubmit}
    />;
    const visitorPassForm = <CreateVisitorPassForm
        closeDropdown={closeDropdown}
        handleInput={handleInput}
        formData={formData as CreateVisitorPassFormDataType}
        setFormData={setFormData as Dispatch<SetStateAction<CreateVisitorPassFormDataType>>}
        onSubmit={onSubmit}
    />

    const formTypes = new Map<string, JSX.Element>([
        ['gatepass', gatepassForm],
        ['visitorpass', visitorPassForm]
    ])

     const formToRender = formTypes.get(type) ||  <p>{`The form of type ${type} has not been created yet`}</p>;

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