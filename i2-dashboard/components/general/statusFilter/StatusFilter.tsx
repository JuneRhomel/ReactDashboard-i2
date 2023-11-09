import { ChangeEventHandler, Fragment } from 'react';
import styles from './StatusFilter.module.css';

export default function ServiceRequestStatusFilter({handler, titles, counts}: {handler: ChangeEventHandler, titles: string[], counts: {[key: string]: number}}) {
    
    return (
        <div className={styles.container}>
            <h3 className={styles.title}>History</h3>
            <div className={styles.radioFilter}>
                {titles.map((title, index) => {
                    const value = title.toLowerCase();
                    const id = removeSpaces(title);
                    return (
                        <Fragment key={index}>
                            {index == 0 ? 
                             <input className={styles.radioInput} onChange={handler} type="radio" name='filterOption' id={`radio${id}`} value={value} defaultChecked/>
                                :
                            <input className={styles.radioInput} onChange={handler} type='radio' name='filterOption' id={`radio${id}`} value={value}/>
                            }
                            <label className={styles.radioLabel} htmlFor={`radio${id}`}>{title}<span className={styles.quantityDisplay}>{counts[value] || 0}</span></label>
                        </Fragment>
                    )
                })}
            </div>
        </div>
    )
}

const removeSpaces = (inputString: string): string => {
    return inputString.replace(/\s/g, '');
}