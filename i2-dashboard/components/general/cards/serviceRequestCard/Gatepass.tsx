import { GatepassPersonnelType, GatepassType } from "@/types/models";
import { useRouter } from "next/router";

const Gatepass = ({gatePass} : {gatePass: GatepassType}) => {
  const router = useRouter();
  const page = router.pathname;
  const type = gatePass.type;
  const personnel: GatepassPersonnelType | null = gatePass.personnel as GatepassPersonnelType | null;
  const personnelName: string = personnel?.personnelName as string;
  return (
    <>
        { page === '/myrequests' ? <p><b>Gate Pass</b></p> : <></> }
        <p><b>Type: </b>{type}</p>
        <p><b>Personel: </b>{personnelName}</p>
        { page === '/gatepass' ? <p><b>Unit: </b>{gatePass.unit}</p> : <></> }
    </>
  )
}

export default Gatepass;