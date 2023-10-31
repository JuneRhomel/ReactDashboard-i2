import { MouseEventHandler } from 'react';
import styles from './SoaButtons.module.css';

export default function SoaButtons({payAction}: {payAction?: MouseEventHandler | undefined}) {
    const generatePDF = () => {
        console.log("Generate PDF Button. Function now yet made")
    }
    return (
        <div className={styles.btnContainer}>
            <button className={styles.btnPdf} onClick={generatePDF}>SOA PDF</button>
            <button className={styles.payNow} onClick={payAction || undefined}>PAY NOW</button>
        </div>
    )
}