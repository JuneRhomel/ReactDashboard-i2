import { ChangeEventHandler } from 'react';
import styles from './ServiceRequestStatusFilter.module.css';

export default function ServiceRequestStatusFilter({handler, counts}: {handler: ChangeEventHandler, counts: {pending: number, approved: number, denied: number}}) {
    return (
        <div className={styles.container}>
            <h3 className={styles.title}>History</h3>
            <div className={styles.radioFilter}>
                <input className={styles.radioInput} onChange={handler} type="radio" name='filterOption' id='radioPending' value='pending' defaultChecked/>
                <label className={styles.radioLabel} htmlFor="radioPending">Pending<span className={styles.quantityDisplay}>{counts['pending']}</span></label>
                <input className={styles.radioInput} onChange={handler} type="radio" name='filterOption' id='radioApproved' value='approved'/>
                <label className={styles.radioLabel} htmlFor="radioApproved">Approved<span className={styles.quantityDisplay}>{counts['approved']}</span></label>
                <input className={styles.radioInput} onChange={handler} type="radio" name='filterOption' id='radioDenied' value='denied'/>
                <label className={styles.radioLabel} htmlFor="radioDenied">Denied<span className={styles.quantityDisplay}>{counts['denied']}</span></label>
            </div>
        </div>
    )
}