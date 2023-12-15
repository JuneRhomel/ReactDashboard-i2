import { SoaPaymentsType } from '@/types/models';
import style from './PaymentCard.module.css';
import getDateTimeString from '@/utils/getDateTimeString';
import formatCurrency from '@/utils/formatCurrency';
import getDTDiff from '@/utils/getDTDiff';

export const PaymentCard = ({transaction} : {transaction: SoaPaymentsType}) => {
  const transactionDate = getDTDiff(transaction?.createdOn);
  const amount = formatCurrency(transaction?.amount);
  const status = transaction?.status;

  return (
    <div className={style.card}>
      <div className={status === 'Invalid' ? `${style.invalid}` :
        status === 'For Verification' ? `${style.forVerification}` :
          `${style.successful}`}>
        <span className={`${style.status} ${style.invalid}`}>{status}</span>
        <p className={style.description}>{transaction.description}</p>
        <p className={style.label}>{transactionDate}</p>
        <p className={style.label}>{transaction?.paymentType}</p>
      </div>
      <div>
        <p className={`${style.amount}`}>{amount}</p>
      </div>
    </div>
  )
}
