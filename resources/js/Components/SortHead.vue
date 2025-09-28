<template>
    <th>
        <button class="table-sort d-flex justify-content-between"
                @click="sortColumn()"
                :class="{
                    'asc': props.modelValue.includes(name),
                    'desc': props.modelValue.includes(`-${name}`),
                }">
            {{ label }}
        </button>
    </th>
</template>

<script setup>

const props = defineProps({
    modelValue: String,
    name: String,
    label: String,
})

const emits = defineEmits(['update:modelValue'])

const sortColumn = () => {
    let rawSorts = props.modelValue.split(", ").filter(sort => sort)
    const descSort = `-${props.name}`

    if(rawSorts.includes(props.name)) {
        rawSorts = rawSorts.filter(sort => sort !== props.name);
        rawSorts.push(descSort)

    } else if(rawSorts.includes(descSort)) {
        rawSorts = rawSorts.filter(sort => sort !== descSort);
    }else {
        rawSorts.push(props.name)
    }

    emits('update:modelValue', rawSorts.join(', '))
}
</script>

