<template>
    <label
        v-if="label"
        :class="{'required': $attrs.hasOwnProperty('required')}"
        class="form-label">
        {{label}}
    </label>
    <multiselect
        v-bind="$attrs"
        :options="convertOptions"
        v-model="selected"
        :taggable="true"
        label="label"
        track-by="value"
        ref="multiselectRef"
        :placeholder="placeholder"
        :class="{'invalid' : error}"
        :multiple="true">
    </multiselect>
    <div class="invalid-feedback d-block" v-if="error">
        {{ error }}
    </div>
</template>

<script setup>
import Multiselect from 'vue-multiselect'
import "vue-multiselect/dist/vue-multiselect.min.css";
import {ref, watch} from "vue";

const props = defineProps({
    label: String,
    modelValue: Array,
    options: Object,
    placeholder: {
        type: String,
        default: "Choose your items"
    },
    error: String
})

const emits = defineEmits(["update:modelValue"])

const convertOptions = Object.entries(props.options).map(([key, value]) => ({
    label: value,
    value: key
}))

const selected = ref(props.modelValue.map(value => ({
    label: convertOptions.find(option => option.value == value)?.label ?? '',
    value: value
})));

watch(selected, (value) => {
    emits('update:modelValue', value.map(val => val.value))
})
</script>

<style>
.multiselect {
    border-radius: var(--tblr-border-radius);
}

.invalid {
    border: 1px solid;
    border-color: var(--tblr-form-invalid-border-color);
}
</style>
