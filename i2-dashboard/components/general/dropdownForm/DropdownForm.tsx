import { Children, ReactElement, cloneElement, isValidElement, useState } from 'react';
import styles from './DropdownForm.module.css';
import { FaCaretDown, FaCaretUp } from "react-icons/fa6";

interface ChildProps {
    closeDropdown: () => void;
}
// I want to change this as I don't think it needs to be written in this way. All this file really does is create a drop-down and put the relevant form as the content.
// A better way is to make this function the dropdown function and simply pass the form to be rendered.
export default function DropdownForm({children}: {children: any}){
    const [isOpen, setIsOpen] = useState(false);

    const handleClick = () => {
        setIsOpen(!isOpen);
    }

    const closeDropdown = () => {
        setIsOpen(false);
    }

    // Pass closeDropdown as a prop to children
    const childrenWithProps = Children.map(children, (child: ReactElement<ChildProps>) => {
        if (isValidElement(child)) {
            return cloneElement(child, { closeDropdown: closeDropdown });
        }
        return child;
    });

    const contentStyle = isOpen ? `${styles.content} ${styles.show}` : `${styles.content} ${styles.hidden}`;
    const dropdownHeaderIcon = isOpen ? <FaCaretUp/> : <FaCaretDown/>;
    
    return (
        <div className={styles.dropdown}>
            <div className={styles.header} onClick={handleClick}>
                <div className={styles.title}>Request Form</div>
                {dropdownHeaderIcon}
            </div>
            <div className={contentStyle}>
                {childrenWithProps}
            </div>
        </div>
    )
}