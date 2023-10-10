import style from './PaymentTransactions.module.css'
import { PaymentCard } from '@/components/general/cards/paymentCard/PaymentCard'
const PaymentTransactions = () => {
    const array: number[] = [1, 2, 3];
    return (
        <div className={style.displayArea}>
            {array.map((element) => (<PaymentCard key={element} />))}

            {/* <div className={style.card}>
                <div>
                    <span className={`${style.status} ${style.invalid} `}>Invalid</span>
                    <p className={style.description}>SOA Payment - October 5, 2023</p>
                    <p className={style.label}>October 5, 2023 3:45 PM</p>
                    <p className={style.label}>Bank Transfer/ Over the counter</p>
                </div>
                <div>
                    <p className={`${style.amount} ${style.text_red}`}>21,159.00</p>
                </div>
            </div>
            <div className={style.card}>
                <div>
                    <span className={`${style.status} ${style.successful} `}>Successful
                    </span>
                    <p className={style.description}>SOA Payment - October 5, 2023</p>
                    <p className={style.label}>October 5, 2023 3:45 PM</p>
                    <p className={style.label}>Bank Transfer/ Over the counter</p>
                </div>
                <div>
                    <p className={`${style.amount} ${style.text_green}`}>21,159.00</p>
                </div>
            </div> */}
        </div>
    )
}

export default PaymentTransactions