import Layout from "@/components/layouts/layout";
import { SoaDetailsType, SoaType,  } from "@/types/models";
import { ParamGetSoaType, ParamGetSoaDetailsType } from "@/types/apiRequestParams";
import authorizeUser from "@/utils/authorizeUser";
import Section from "@/components/general/section/Section";
import api from "@/utils/api";
import mapObject from "@/utils/mapObject";

export async function getServerSideProps(context: any) {
  // Do the stuff to check if user is authenticated
  let response;
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
    limit: 1,
  }
  response = await api.soa.getSoa(soaParams, token);
  const soas: SoaType[] = await response?.json();
  const soa: SoaType = mapObject(soas.shift() as SoaType) as SoaType;

  
  const soaDetailsParams: ParamGetSoaDetailsType = {
    accountcode: accountCode,
    soaId: parseInt(soa.id),
  }
  response = await api.soa.getSoaDetails(soaDetailsParams, token);  // get soa details (transactions for this soa)
  const soaDetails: SoaDetailsType[] = mapObject(await response?.json()) as SoaDetailsType[];
  return {props: {user, soa, soaDetails}};
}

export default function Dashboard(props : any) {
  // else redirect to login
  const soaProps = {
    title: 'SOA',
    headerAction: null,
    data: props.soa,
  }

  const paymentTransactionsProps = {
    title: 'Payment Transactions',
    headerAction: "Show All",
    data: props.soaDetails as SoaDetailsType,
    };

  return (
    <Layout title="Dashboard" >
        <Section props={soaProps}></Section>
        <Section props={paymentTransactionsProps} />
    </Layout>
  )
}
