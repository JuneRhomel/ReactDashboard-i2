import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import Layout from "@/components/layouts/layout";
import { InputProps, SoaDetailsType, SoaPaymentsType, SoaType } from "@/types/models";
import formatCurrency from "@/utils/formatCurrency";
import getDateString from "@/utils/getDateString";
import styles from './ViewSoa.module.css';
import SoaButtons from "@/components/general/button/SoaButtons";
import InputGroup from "@/components/general/form/inputGroup/InputGroup";
import PayNowButton from "@/components/general/button/payNowButton/PayNowButton";
import { ChangeEvent, MouseEventHandler, useState } from "react";
import api from "@/utils/api";

export default function ViewSoa({soa, soaDetails, soaPayments, error}: {
soa: SoaType | undefined,
soaDetails: SoaDetailsType[] | undefined,
soaPayments: SoaPaymentsType[] | undefined,
error: any}) {

    if (error) {
        // handle error
    }

    const [amount, setAmount] = useState('');
    const [fileToUpload, setFileToUpload] = useState(null);
    const [fee, setFee] = useState('');

    const showPaymentContainer = (e: MouseEvent) => {
        const paymentContainer = document.getElementById('paymentContainer') as HTMLElement;
        const button = e.currentTarget as HTMLButtonElement;
        paymentContainer.hidden = false;
        window.scrollTo(0, document.body.scrollHeight);
        button.style.display = 'none';
    }
    
    const inputProps: InputProps = {
        name: 'amount',
        label: 'Amount',
        type: 'text',
        value: amount,
    }

    const handleInput = (event: any) => {
        const value = event.target.value;
        setAmount(value);
    }

    const handleFileSelection = (event: any) => {
        console.log(event.target.files[0])
        const file = event.target.files[0];
        setFileToUpload(file);
    }

    const submitForm = async (event: any) => {
        event.preventDefault();
        const amountInput = document.getElementById('amount') as HTMLInputElement;
        const amount = amountInput.value;
        const fileInput = document.getElementById('file') as HTMLInputElement;
        const file = (fileInput.files as FileList)[0];
        const formData: {[key: string]: any} = {
            amount: amount,
            file: file,
        }
        const response = await api.soa.saveSoaPayment(formData);
        setFee(response);
    }

    const statementDate = getDateString(null, parseInt(soa?.monthOf as string), parseInt(soa?.yearOf as string));
    const subTotal = soaDetails?.reduce((sum, detail) => sum + parseFloat(detail.amount), 0) as number;
    const total = subTotal - parseFloat(soa?.balance as string);
    const totalPayments = soaPayments?.reduce((sum, payment) => sum + parseFloat(payment.amount), 0) as number;
    const amountDue = total - totalPayments;
    const statusClass = soa?.status === 'Paid' ? `${styles.status} ${styles.paid}` : `${styles.status} ${styles.unpaid}`;
    return (
        <Layout title='View Soa'>
            <ServiceRequestPageHeader title="Back"/>
            <h1 className={styles.title}>Statement Of Account</h1>
            <h3 className={styles.statementDate}>{`for ${statementDate}`}</h3>
            <div className={styles.container}>
                <div className={styles.soaStatus}>
                    <h3>Status</h3>
                    <h3 className={statusClass}>For Verification</h3>
                </div>
                <table className={styles.table}>
                    <tbody>
                        <tr>
                            <th>Descriptions</th>
                            <th>Amount</th>
                        </tr>
                        {soaDetails?.map((detail: SoaDetailsType) => (
                            <tr key={detail.id}>
                                <td>{detail.type}</td>
                                <td>{formatCurrency(detail.amount)}</td>
                            </tr>
                        ))}
                        <tr>
                            <th>Sub Total</th>
                            <th>{formatCurrency(subTotal)}</th>
                        </tr>
                        <tr className={styles.outstandingBalance}>
                            <td>Outstanding Balance</td>
                            <td>{soa?.balance === '0' ? soa?.balance : formatCurrency(soa?.balance as string)}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>{formatCurrency(total)}</th>
                        </tr>
                        <tr>
                            <th>Less</th>
                            <th></th>
                        </tr>
                        {soaPayments?.map((payment: SoaPaymentsType) => (
                            <tr key={payment.id}>
                                <td className={styles.particular}>{payment.particular}</td>
                                <td>{formatCurrency(payment.amount)}</td>
                            </tr>
                        ))}
                        <tr>
                            <th>Total Due</th>
                            <th>{formatCurrency(amountDue)}</th>
                        </tr>
                    </tbody>
                </table>
                <SoaButtons payAction={showPaymentContainer}/>
            </div>
            
            <div className={`${styles.container} ${styles.paymentContainer}`} id='paymentContainer' hidden>
                <h3>Choose your payment method</h3>
                <input type="radio" name="bankTransfer" id="bankTransfer" />
                <label htmlFor="bankTransfer">Bank transfer/Over the counter</label>
                <form action="/">
                    <InputGroup props={inputProps} onChange={handleInput}/>
                    <p>
                        <strong>NOTE:</strong> Please upload a clear picture of the proof of payment.
                    </p>

                    <h4>Proof of payment</h4>
                    
                    <input className={styles.fileInput} type="file" name="file" id="file" onChange={handleFileSelection}/>
                    {fileToUpload && <p>{(fileToUpload as File).name}</p>}
                    <label className={styles.attachFileButton} htmlFor="file">
                        Attach File/Photo
                    </label>
                    
                    <PayNowButton onClick={submitForm}/>
                    
                </form>
            </div>

        </Layout>

    )
}