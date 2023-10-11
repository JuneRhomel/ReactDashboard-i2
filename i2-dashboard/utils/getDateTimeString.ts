import getDateString from "./getDateString";

const getDateTimeString = (dateTime: string) : string => {
    const inputDate = new Date(dateTime);
    const year = inputDate.getFullYear();
    const month = inputDate.getMonth();
    const day = inputDate.getDate();
    const hours = inputDate.getHours();
    const minutes = inputDate.getMinutes();
    const amPM = hours >= 12 ? "PM" : "AM";
    const formattedHours = hours % 12 || 12;
    console.log(month)

    const dateTimeString = `${getDateString(day, month + 1, year)} ${formattedHours}:${String(minutes).padStart(2,'0')} ${amPM}`;
    return dateTimeString;
}

export default getDateTimeString