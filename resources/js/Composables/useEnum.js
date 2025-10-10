
export function useEnum(enums) {
    const selectEnum = enums.reduce((carry, status) => {
            carry[status.value] = status.label
            return carry
        }, {})

    const defaultEnum = enums.find(status => status.isDefault)?.value ?? null

    const switchEnum = enums.length === 2
        ? enums.reduce((carry, status) => {
            carry[status.value] = status.asBoolean
            return carry
        }, {})
        : {}


    const display = (status) => enums.find(val => val.value === status)

    return {
        select: selectEnum,
        'switch': switchEnum,
        'default' : defaultEnum,
        display
    }
}
