

export default function getDTDiff(datefrom: any) {
    const now = new Date().toLocaleString("en-US", { timeZone: "Asia/Taipei" });
    const currentDate = new Date(now);
    var date1: any = new Date(datefrom * 1000); // Convert seconds to milliseconds
    var date2: any = new Date(currentDate);

    var diff = Math.abs(date2 - date1);

    var years = Math.floor(diff / (365 * 24 * 60 * 60 * 1000));
    diff -= years * (365 * 24 * 60 * 60 * 1000);

    var months = Math.floor(diff / (30 * 24 * 60 * 60 * 1000));
    diff -= months * (30 * 24 * 60 * 60 * 1000);

    var days = Math.floor(diff / (24 * 60 * 60 * 1000));
    diff -= days * (24 * 60 * 60 * 1000);

    var hours = Math.floor(diff / (60 * 60 * 1000));
    diff -= hours * (60 * 60 * 1000);

    var minutes = Math.floor(diff / (60 * 1000));

    var result = '';
    result += (years === 0) ? '' : years + ' yrs ';
    result += (months === 0) ? '' : months + ' mos ';
    result += (days === 0) ? '' : days + ' days ';
    result += (hours === 0) ? '' : hours + ' hrs ';
    result += (minutes === 0) ? '0 min' : minutes + ' mins';

    return result;
}
