const getDateString = (dayOrDateString: string | number | null, month?: number, year?: number) : string=> {
    let dateString = '';
    const monthNames = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];

    if (typeof dayOrDateString === 'string'){
        const parts = dayOrDateString.split('-');
        const year = parseInt(parts[0]);
        const month = parseInt(parts[1]);
        const day = parseInt(parts[2]);
        return getDateString(day, month, year);
    } else {
        dateString += `${monthNames[month as number - 1]} `;
        if (dayOrDateString != null) {
            dateString += `${dayOrDateString}, `
        }
        dateString += year;
    }
    return dateString;
}

export default getDateString