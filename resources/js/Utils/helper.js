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

