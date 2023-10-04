import { User } from "@/types/models";
import authorizeUser from "@/utils/authorizeUser";

export function getServerSideProps(context : any) {
  // Do the stuff to check if user is authenticated
  const token : string = context.req.cookies.token;
  return authorizeUser(token);
}

export default function Dashboard( {user} : {user: any}) {
  // if data == authorized return the dashboard
  // else redirect to login
  return (
    <div>{JSON.stringify(user)}</div>
  )
}
