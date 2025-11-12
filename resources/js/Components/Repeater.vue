<template>
    <label class="form-label" v-if="label">{{label}}</label>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th v-for="head in heads" :key="head">
                    {{ head.label ?? head }}
                    <span class="required"
                          v-if="head?.required ?? true">
                        *
                    </span>
                </th>
                <th v-if="withActions">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in items" :key="item._uid">
                <slot :item="item" :index="index"/>
                <td v-if="withActions">
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

import {computed, ref, watch} from "vue";
import {IconCopyPlusFilled, IconCopyXFilled} from "@tabler/icons-vue"

const props = defineProps({
    label: String,
    name: String,
    errors: Object,
    modelValue: Array,
    defaultRow: {
        type: Object,
        default: {}
    },
    heads: Array,
    minItems: {
        type: Number,
        default: 1
    },
    withActions: {
        type: Boolean,
        default: true,
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
        value['_uid'] = Date.now() + Math.random()
        return value;
    });
});


const addRow = () => {
    localValue.value.push({...props.defaultRow})
    emits('update:modelValue', localValue.value)
}

const removeRow = (index) => {
    if (localValue.value.length <= props.minItems) return

    localValue.value.splice(index, 1)
    emits('update:modelValue', localValue.value)
}

watch(() => props.modelValue, (value) => {
    localValue.value = value;
})
</script>

<style scoped>
 .required {
     margin-left: .25rem;
     color: #d63939;
 }
</style>

