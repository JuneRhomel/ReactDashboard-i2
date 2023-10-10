import SoaCard from '../pages/soa/SoaCard';
import styles from './Section.module.css';
const Section = ({props}: {props: any}) => {
    let cardToRender;
    if (props.title.toLowerCase() === 'soa') {
        cardToRender = <SoaCard props={props.data}/>
    } else {
        cardToRender = "A Different Card"
    }
    return (
        <>
            <div className={styles.header}>
                <h1 className={styles.title}>{props.title}</h1>
                {props.headerAction ? <h2 className={styles.action}>{props.headerAction}</h2> : <></>}
            </div>

            <div className={styles.container}>
                {cardToRender}
            </div>
        </>
    )
}

export default Section