import { GatePassPersonnelType, GatePassType } from "@/types/models";

const GatePass = ({gatePass} : {gatePass: GatePassType}) => {
  const type = gatePass.type;
  const personnel: GatePassPersonnelType | null = gatePass.personnel as GatePassPersonnelType | null;
  const personnelName: string = personnel?.personnelName as string;
  return (
    <>
        <p><b>Gate Pass</b></p>
        <p><b>Type: </b>{type}</p>
        <p><b>Personel: </b>{personnelName}</p>
    </>
  )
}

export default GatePass;