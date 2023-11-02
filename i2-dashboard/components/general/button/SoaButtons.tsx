import { MouseEventHandler } from 'react';
import styles from './SoaButtons.module.css';
import PayNowButton from './payNowButton/PayNowButton';

export default function SoaButtons({payAction}: {payAction: any}) {
    const generatePDF = () => {
        console.log("Generate PDF Button. Function now yet made")
    }
    return (
        <div className={styles.btnContainer}>
            <button className={styles.btnPdf} onClick={generatePDF}>SOA PDF</button>
            <PayNowButton onClick={payAction}/>
        </div>
    )
}