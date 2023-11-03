import Soa from "@/components/pages/soa/Soa";
import { SoaPaymentsType, SoaType } from "@/types/models";
import { ParamGetSoaDetailsType, ParamGetSoaType } from "@/types/apiRequestParams";
import api from "@/utils/api";
import authorizeUser from "@/utils/authorizeUser";
import encryptData from "@/utils/encryptData";

export async function getServerSideProps(context: any) {
  // Need to update this function to address cases where the user is not authenticated therefor authorizeUser(jwt) returns null
  //Fetch all the soa objects.
  const accountCode: string = process.env.TEST_ACCOUNT_CODE as string;
  const jwt = context.req.cookies.token;
  const user = authorizeUser(jwt);
  if (!user) {
    return {redirect : {destination: '/?error=accessDenied', permanent: false}};
  }

  const token = `${user?.token}:tenant`;
  const soaParams: ParamGetSoaType = {
    accountcode: accountCode,
    userId: user?.tenantId as number,
  }
  const paymentTransactionsParams: ParamGetSoaDetailsType = {
    accountcode: accountCode,
    limit: 20,
  }
  const getSoaPromise = api.soa.getSoa(soaParams, token);  // get all soas
  const getSoaPaymentsPromise = api.soa.getSoaPayments(paymentTransactionsParams, token);
  const [soaResponse, paymentTransactionsResponse] = await Promise.all([getSoaPromise, getSoaPaymentsPromise]);
  const soas = soaResponse.success ? soaResponse.data as SoaType[] : undefined;
  const allSoaPayments = paymentTransactionsResponse.success ? paymentTransactionsResponse.data as SoaPaymentsType[] : undefined;
  const soaIds = soas?.map((soa) => soa.id)
  const userSoaPayments = allSoaPayments?.filter((soaDetail) => soaIds?.includes(soaDetail.soaId));
  const filteredSoaPayments = userSoaPayments?.filter((detail: SoaPaymentsType) => {
    return !(detail.particular.includes("SOA Payment") && detail.status === "Successful") && !detail.particular.includes("Balance");
  });

  const currentSoa = soas?.shift() as SoaType;
  currentSoa.encId = encryptData(currentSoa?.id); // This needs to be moved to the api call somehow
  const paidSoas = soas?.filter((soa: SoaType) => 
    soa.status === "Paid" && soa.id != currentSoa?.id
    );
  const unpaidSoas = soas?.filter((soa: SoaType) =>
    (soa.status === "Unpaid" || soa.status === "Partially Paid") && soa.id != currentSoa?.id
    );

    return {
    props: {
      currentSoa,
      paidSoas,
      unpaidSoas,
      paymentTransactions: filteredSoaPayments,
    }
  }
}

export default Soa
