<template>
    <label v-if="label" class="form-label">{{ label }}</label>
    <select class="form-select"
            :class="{ 'is-invalid':error}"
            v-bind="$attrs"
            :id="name"
            v-model="localValue">
        <slot/>
    </select>
    <div class="invalid-feedback" v-if="error">
        {{ error }}
    </div>
</template>

<script setup>
import {defineProps, ref, watch} from 'vue'

const props = defineProps({
    name: String,
    label: {
        type: String,
        default: ""
    },
    modelValue: {
        type: [String, Number, Array, null],
        default: null
    },
    error: String
})
const localValue = ref(props.modelValue);
const emit = defineEmits(['update:modelValue'])

watch(localValue, (value) => emit('update:modelValue', value))

</script>

<style>
.form-select.is-invalid:not([multiple]):not([size]) {
    --tblr-form-select-bg-icon: null,
}
</style>
