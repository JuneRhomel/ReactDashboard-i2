import Layout from "@/components/layouts/layout";
import { SoaDetailsType, SoaPaymentsType, SoaType } from "@/types/models";
import formatCurrency from "@/utils/formatCurrency";
import getDateString from "@/utils/getDateString";

export default function ViewSoa({soa, soaDetails, soaPayments, error}: {
soa: SoaType | undefined,
soaDetails: SoaDetailsType[] | undefined,
soaPayments: SoaPaymentsType[] | undefined,
error: any}) {

    if (error) {
        // handle error
    }
    console.log(soaPayments)
    const statementDate = getDateString(null, parseInt(soa?.monthOf as string), parseInt(soa?.yearOf as string));
    const subTotal = soaDetails?.reduce((sum, detail) => sum + parseFloat(detail.amount), 0) as number;
    const total = subTotal - parseFloat(soa?.balance as string);
    return (
        <Layout title='View Soa'>
            <h1>{`for ${statementDate} Summary`}</h1>
            <table>
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
                <tr>
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
                        <td>{payment.particular}</td>
                        <td>{formatCurrency(payment.amount)}</td>
                    </tr>
                ))}
                </tbody>
            </table>
        </Layout>

    )
}