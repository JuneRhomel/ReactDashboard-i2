import Login from "./login";
import authorizeUser from '@/utils/authorizeUser';

const pageTitle: string = "Welcome to Inventi I2";

export function getServerSideProps(context: any) {
  const jwt = context.req.cookies?.token;
  const user = authorizeUser(jwt);
  if (user) {
    console.log("User already logged in")
    return {redirect : {destination: '/dashboard', permanent: false}};
  }
  return {
    props: {}
  }
}

export default function Home() {
  return (
    <>
       <Login/> 
    </>

  )
}
