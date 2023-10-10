import { SoaDetailsType } from '@/types/models';
import style from './PaymentCard.module.css';
import getDateTimeString from '@/utils/getDateTimeString';

export const PaymentCard = ({transaction} : {transaction: SoaDetailsType}) => {
  console.log(transaction);
  const transactionDate = getDateTimeString(transaction?.transactionDate);
  const amount = transaction?.amount;
  return (
    <div className={style.card}>
        <div>
            <span className={`${style.status} ${style.invalid} `}>{transaction?.status}</span>
            <p className={style.description}>{transaction.particular}</p>
            <p className={style.label}>{transactionDate}</p>
            <p className={style.label}>{transaction?.paymentType}</p>
        </div>
        <div>
            <p className={`${style.amount} ${style.text_red}`}>{amount}</p>
        </div>
    </div>
  )
}
