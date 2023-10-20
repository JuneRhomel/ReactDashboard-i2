import styles from './ItemDetails.module.css';

export default function ItemDetails({labels, item}: {labels: string[], item: any}) {

    return (
        <div className={styles.container}>
            <div className={styles.labels}>
                {labels.map((label, index)=> <p key={index}>{label}</p>)}
            </div>
            <div className={styles.values}>
                {Object.keys(item).map((key, index) => <p key={index}>{item[key]}</p>)}
            </div>
        </div>
    )
}