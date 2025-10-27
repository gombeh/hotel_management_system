import moment from "moment";

export const isString = (myVar) => {
    return typeof myVar === 'string' || myVar instanceof String;
}

export const slugify = str => {
    return str
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

export function isEmpty(obj) {
    return Object.keys(obj).length === 0;
}

export const invertObject = (obj) =>
    Object.fromEntries(
        Object.entries(obj).map(([key, value]) => [value, key])
    );

export const diffDays = (day1, day2, hasPositive = true) => {
    const date1 = moment(day1);
    const date2 = moment(day2);

    let days = date2.diff(date1, 'days');

    if (hasPositive) {
        days = Math.abs(days);
    }
    return days;
}


export function capitalize(val) {
    return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

export const currentDate = () => moment().format('Y-M-D');

export function addDays(date, days) {
    const newDate = moment(date).add(days, 'days');
    return newDate.format('Y-M-D');
}
