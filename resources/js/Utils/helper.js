export const isString = (myVar) => {
    return typeof myVar === 'string' || myVar instanceof String;
}


export const wildCardProperty = (object, regex) => {
    return Object.keys(object).filter(function(v) { return regex.test(v) });
}
