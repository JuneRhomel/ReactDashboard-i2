import Link from "next/link";
import { NextRouter, useRouter } from "next/router";
import { useState } from "react";

export default function Logout() {
    const [timer, setTimer] = useState(3);
    const router: NextRouter = useRouter();
    setTimeout(()=>{
        router.push('/');
    }, 3000)
    const deductFromTimer = ()=>{
        setTimer(timer-1);
    }
    setInterval(deductFromTimer, 1000);
  return (
    <>
        <h1>Logout was successful</h1>
        <p>You will be redirected to the login page in {timer} seconds</p>
        <Link href='/'><button>Go to Login page</button></Link>
    </>    
  )
}
