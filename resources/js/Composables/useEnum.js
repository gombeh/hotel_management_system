
export function useEnum(enums) {
    const selectEnum = enums.reduce((carry, status) => {
            carry[status.value] = status.label
            return carry
        }, {})

    const defaultEnum = enums.find(status => status.isDefault)?.value ?? null

    const display = (status) => enums.find(val => val.value === status)

    return {
        selectEnum,
        defaultEnum,
        display
    }
}
