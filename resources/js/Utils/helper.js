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
    const date1 = new Date(day1);
    const date2 = new Date(day2);

    let  diffTime = date2 - date1

    if(hasPositive) {
         diffTime = Math.abs(diffTime);
    }

    console.log(date1, date2, diffTime, day1, day2)
    return Math.floor(diffTime / (1000 * 60 * 60 * 24));
}


export function capitalize(val) {
    return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}

export const currentDate  = () => new Date().toISOString().slice(0, 10);

export function addDays(date, days) {
    const result = new Date(date);
    result.setDate(result.getDate() + days);
    return result.toISOString().slice(0, 10);
}
