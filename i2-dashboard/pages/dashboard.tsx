import authorizeUser from "@/utils/authorizeUser";
import AuthContext from "@/utils/context/AuthProvider"
import { useState, useContext } from "react"

export function getServerSideProps(context : any) {
  // Do the stuff to check if user is authenticated
  const token : string = context.req.cookies.token;

  const user = authorizeUser(token);
  return user ? {
    props: {
      user
      }
    } : {
      redirect: {destination: "/", permanent: false}
    }
  }

export default function Dashboard( {user} : {user: any}) {
  // if data == authorized return the dashboard
  // else redirect to login
  return (
    <div>{JSON.stringify(user)}</div>
  )
}
