import { MouseEventHandler } from 'react';
import styles from './Modal.module.css';

export default function Modal({isOpen, onClose, children}: {isOpen: boolean, onClose?: MouseEventHandler, children: any}) {
    if (!isOpen) return null;

    return (
        <div className={styles.modalOverlay}>
            <div className={styles.modal}>
                <div className={styles.modalHeader}>
                    {onClose && <span className={styles.closeButton} onClick={onClose}>&times;</span>}
                </div>
                <div className={styles.modalContent}>
                    {children}
                </div>
            </div>
        </div>
        
    )
}