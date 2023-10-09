import { useRouter } from 'next/router';
import Login from "./login";

const pageTitle: string = "Welcome to Inventi I2";

export default function Home() {
  const router = useRouter();
  return (
    <>
       <Login/> 
    </>

  )
}
