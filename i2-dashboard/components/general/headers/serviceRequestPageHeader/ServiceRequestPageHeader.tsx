import Button from '../../button/Button'
import styles from './ServiceRequestPageHeader.module.css'

export default function ServiceRequestPageHeader({title}: {title: string}) {
    return (
        <div className={styles.container}>
            <Button type='back'/>
            <div className={styles.title}>{title}</div>
        </div>
    )
}


