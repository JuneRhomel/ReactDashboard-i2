import style from './PaymentCard.module.css';

export const PaymentCard = () => {
  return (
    <div className={style.card}>
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
  )
}
