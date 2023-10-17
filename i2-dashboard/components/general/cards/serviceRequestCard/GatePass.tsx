import gatepass from "@/pages/gatepass";
import { GatePassPersonnelType, GatePassType } from "@/types/models";
import { useRouter } from "next/router";

const GatePass = ({gatePass} : {gatePass: GatePassType}) => {
  const router = useRouter();
  const page = router.pathname;
  const type = gatePass.type;
  const personnel: GatePassPersonnelType | null = gatePass.personnel as GatePassPersonnelType | null;
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

export default GatePass;