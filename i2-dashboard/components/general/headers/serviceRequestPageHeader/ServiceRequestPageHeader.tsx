import { useRouter } from 'next/router';
import Button from '../../button/Button'
import styles from './ServiceRequestPageHeader.module.css'

export default function ServiceRequestPageHeader({title}: {title: string}) {
    const router = useRouter();
    const handleClick = (event:any) => {
        event.preventDefault();
        router.back();
    }

    return (
        <div className={styles.container}>
            <Button onClick={handleClick}type='back'/>
            <div className={styles.title}>{title}</div>
        </div>
    )
}


