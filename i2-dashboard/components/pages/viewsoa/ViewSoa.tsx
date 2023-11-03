import ServiceRequestPageHeader from "@/components/general/headers/serviceRequestPageHeader/ServiceRequestPageHeader";
import Layout from "@/components/layouts/layout";
import { InputProps, SaveSoaPaymentFormData, SoaDetailsType, SoaPaymentsType, SoaType } from "@/types/models";
import formatCurrency from "@/utils/formatCurrency";
import getDateString from "@/utils/getDateString";
import styles from './ViewSoa.module.css';
import SoaButtons from "@/components/general/button/SoaButtons";
import InputGroup from "@/components/general/form/inputGroup/InputGroup";
import PayNowButton from "@/components/general/button/payNowButton/PayNowButton";
import { useState } from "react";
import api from "@/utils/api";
import Modal from "@/components/general/modal/Modal";
import { useRouter } from "next/router";

export default function ViewSoa({soa, soaDetails, soaPayments, error}: {
soa: SoaType | undefined,
soaDetails: SoaDetailsType[] | undefined,
soaPayments: SoaPaymentsType[] | undefined,
error: any}) {
    const router = useRouter()
    const [amountErrorMessage, setAmountErrorMessage] = useState('');
    const [fileErrorMessage, setFileErrorMessage] = useState('');
    const [status, setStatus] = useState('');
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [amount, setAmount] = useState('');
    const [fileToUpload, setFileToUpload] = useState(null);

    if (error) {
        // handle error
        return (
            <Layout title='Statement of Account'>
                <h2>There was an error fetching your statement of account. Please try again</h2>
                <h3>If the error persists, please contact your building administrator</h3>
            </Layout>
        )
    }
    const backToPaymentForm = () => {
        setIsModalOpen(false);
        setAmount('');
        setFileToUpload(null);
    }

    const formSubmitMessage = new Map<string, any>([
        ['submitting',
            <h3 key='submittingForm'>Please wait while we submit your payment...</h3>
        ],
        ['success',
            <div className={styles.submitMessage} key='successfulSubmit'>
                <h3>Thank you for making a SOA Payment</h3>
                <div>Your payment was sucessfully saved</div>
                <button className={styles.toDashboardButton} onClick={() => router.push('/dashboard')}>Return to Dashboard</button>
            </div>
        ],
        ['failed',
            <div className={styles.submitMessage} key='failedSubmit'>
                <h3>Payment Unsuccessful</h3>
                <div>Please try again...</div>
                <button className={styles.tryAgainButton} onClick={backToPaymentForm}>Try again</button>
            </div>
        ]
    ])

    const showPaymentContainer = (e: MouseEvent) => {
        const paymentContainer = document.getElementById('paymentContainer') as HTMLElement;
        const button = e.currentTarget as HTMLButtonElement;
        paymentContainer.style.display = 'flex';
        window.scrollTo(0, document.body.scrollHeight);
        button.style.display = 'none';
    }

    const showForm = () => {
        const paymentForm = document.getElementById('paymentForm') as HTMLElement;
        paymentForm.style.display = 'flex';
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
        setAmountErrorMessage('');
    }

    const handleFileSelection = (event: any) => {
        console.log(event.target.files[0])
        const file = event.target.files[0];
        setFileToUpload(file);
        setFileErrorMessage('');
    }

    const submitForm = async (event: any) => {
        event.preventDefault();
        let isValid = true;
        const amountInput = document.getElementById('amount') as HTMLInputElement;
        const amount = amountInput.value;
        const fileInput = document.getElementById('file') as HTMLInputElement;
        const file = (fileInput.files as FileList)[0];
        if (isNaN(parseFloat(amount))) {
            setAmountErrorMessage('Please enter a valid amount.');
            isValid = false;
        }
        if (!file) {
            setFileErrorMessage('Proof of payment must be included with payment. Please select a file to upload');
            isValid = false;
        }
        if (file) {
            const fileSizeInMB = file.size / (1024 * 1024);
            if (fileSizeInMB > 1) {
                setFileErrorMessage('File size is too large. The maximum file size is 1 MB');
                isValid = false;
            }
        }
        if (isValid) {
            setStatus('submitting');
            setIsModalOpen(true);
            const formData: SaveSoaPaymentFormData = {
                soaId: soa?.id as string,
                amount: amount,
                file: file,
                paymentType: 'Bank Transfer/ Over the Counter',
            }
            const response = await api.soa.saveSoaPayment(formData);
            response.success ? setStatus('success') : setStatus('failed');
        }
    }

    const statementDate = getDateString(null, parseInt(soa?.monthOf as string), parseInt(soa?.yearOf as string));
    const subTotal = soaDetails?.reduce((sum, detail) => sum + parseFloat(detail.amount), 0) as number;
    const total = subTotal - parseFloat(soa?.balance as string);
    const totalPayments = soaPayments?.reduce((sum, payment) => sum + parseFloat(payment.amount), 0) as number;
    const amountDue = total - totalPayments;
    const statusClass = soa?.status === 'Paid' ? `${styles.status} ${styles.paid}` : `${styles.status} ${styles.unpaid}`;
    return (
        <Layout title='Statement of Account'>
            <ServiceRequestPageHeader title="Back"/>
            <h1 className={styles.title}>Statement Of Account</h1>
            <h3 className={styles.statementDate}>{`for ${statementDate}`}</h3>
            <div className={styles.container}>
                <div className={styles.soaStatus}>
                    <h3>Status</h3>
                    <h3 className={statusClass}>For Verification</h3>
                </div>

                {/* SOA Table */}
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
            
            {/* Payment Container */}
            <div className={`${styles.container} ${styles.paymentContainer}`} id='paymentContainer' hidden>
                <h3>Choose your payment method</h3>
                <div className={styles.radioInput}>
                    <input type="radio" name="bankTransfer" id="bankTransfer" onChange={showForm}/>
                    <label htmlFor="bankTransfer"><strong>Bank transfer/Over the counter</strong></label>
                </div>
                <form action="/" className={styles.paymentForm} id='paymentForm'>
                    <div className={styles.amount}>
                        <InputGroup props={inputProps} onChange={handleInput}/>
                        <p className={styles.errorMessage}>{amountErrorMessage}</p>
                    </div>
                    <p>
                        <strong>NOTE:</strong> Please upload a clear picture of the proof of payment.
                    </p>

                    <div className={styles.fileInputContainer}>
                        <div className={styles.proofOfPayment}>
                            <h4>Proof of payment</h4>
                            <p>{fileToUpload ? (fileToUpload as File).name : 'No file selected'}</p>
                        </div>
                        <input className={styles.fileInput} type="file" name="file" id="file" onChange={handleFileSelection}/>
                        <p className={styles.fileErrorMessage}>{fileErrorMessage}</p>
                        <label className={styles.attachFileButton} htmlFor="file">
                            Attach File/Photo
                        </label>

                    </div>
                    
                    <PayNowButton onClick={submitForm}/>
                </form>
            </div>

            <Modal isOpen={isModalOpen}>
                {formSubmitMessage.get(status)}
            </Modal>

        </Layout>

    )
}