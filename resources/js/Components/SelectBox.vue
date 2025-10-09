<template>
    <label v-if="label"
           class="form-label"
           :class="{'required': $attrs.hasOwnProperty('required')}">
        {{ label }}
    </label>
    <select class="form-select"
            :class="{ 'is-invalid':error}"
            v-bind="$attrs"
            :id="name"
            v-model="localValue">
        <option value="" v-if="placeholder">{{placeholder}}</option>
        <option v-for="[id, label] in Object.entries(options)" :value="id" :key="id">
            {{ label }}
        </option>
    </select>
    <div class="invalid-feedback" v-if="error">
        {{ error }}
    </div>
</template>

<script setup>
import {defineProps, ref, watch} from 'vue'

const props = defineProps({
    options: Object,
    name: String,
    label: {
        type: String,
        default: ""
    },
    modelValue: {
        type: [String, Number, Array, null],
        default: ""
    },
    error: String,
    placeholder: {
        type: String,
        default: ""
    }
})
const localValue = ref(props.modelValue ?? "");
const emit = defineEmits(['update:modelValue'])

watch(localValue, (value) => emit('update:modelValue', value))

</script>

<style>
.form-select.is-invalid:not([multiple]):not([size]) {
    --tblr-form-select-bg-icon: null,
}
</style>
