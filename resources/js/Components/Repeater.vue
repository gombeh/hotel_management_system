<template>
    <label class="form-label">{{label}}</label>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th v-for="head in heads" :key="head">{{ head }}</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items" :key="index">
                <slot :item="item" :index="index"/>
                <td>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-danger p-2" @click="removeRow(index)">
                            <IconCopyXFilled class="icon m-0" />
                        </button>
                        <button type="button" class="btn btn-primary" @click="addRow" v-if="index === items.length - 1">
                            <IconCopyPlusFilled class="icon" />
                            Add
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>

import {computed, ref} from "vue";
import {IconCopyPlusFilled, IconCopyXFilled} from "@tabler/icons-vue"

const props = defineProps({
    label: String,
    name: String,
    errors: Object,
    modelValue: Array,
    defaultRow: Object,
    heads: Array,
    minItems: {
        type: Number,
        default: 1
    }
})

const emits = defineEmits(["update:modelValue"])

const localValue = ref(props.modelValue)

const items = computed(() => {
    return localValue.value.map((value, index) => {
        let errors = {};
        Object.keys(value).forEach((key) => {
            const findError = props.errors?.[`${props.name}.${index}.${key}`] ?? false;
            if (findError) {
                errors[key] = findError;
            }
        });
        value['errors'] = errors;
        return value;
    });
});


const addRow = () => {
    localValue.value.push({...props.defaultRow})
    emits('update:modelValue', localValue.value)
}

const removeRow = (index) => {
    if (localValue.value.length <= props.minItems) return //todo problem with remove item and change label select

    localValue.value.splice(index, 1)
    emits('update:modelValue', localValue.value)
}
</script>

