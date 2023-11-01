import { MouseEventHandler } from 'react';
import styles from './PayNowButton.module.css';

export default function PayNowButton({onClick}: {onClick: MouseEventHandler}) {
    return (
        <button className={styles.payNow} onClick={onClick}>PAY NOW</button>
    )
}