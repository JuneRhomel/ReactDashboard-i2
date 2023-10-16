import { GuestType, VisitorsPassType, WorkDetailType, WorkPermitType } from "@/types/models";
import getDateString from "@/utils/getDateString";

const VisitorPass = ({visitorPass} : {visitorPass: VisitorsPassType}) => {
    const type = "Visitor Pass";
    const arrivalDate = getDateString(visitorPass.arrivalDate);
    const guests: GuestType[] = visitorPass.guests as GuestType[];
    let guestNames = '';
    guests.map((guest: GuestType, index: number) => {
        index == guests.length - 1 ? guestNames += guest.guestName : guestNames += `${guest.guestName}, `;
    })
  return (
    <>
        <p><b>{type}</b></p>
        <p><b>Arrival Date </b>{arrivalDate}</p>
        <p><b>Arrival Time </b>{visitorPass.arrivalTime}</p>
        <p><b>Guests: </b>{guestNames}</p>
    </>
  )
}

export default VisitorPass;