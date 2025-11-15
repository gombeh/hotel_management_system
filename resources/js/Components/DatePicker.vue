<template>
    <label v-if="label"
           :class="{'required': $attrs.hasOwnProperty('required')}"
           class="form-label">
        {{ label }}
    </label>
    <VueDatePicker
        v-bind="$attrs"
        :value="modelValue"
        v-model="date"
        :class="{ 'is-invalid': error }"
        :autocomplete="autocomplete"
        :placeholder="placeholder"
        :dark="theme === 'dark'">
    </VueDatePicker>
    <div class="invalid-feedback" v-if="error">
        {{ error }}
    </div>
</template>

<script setup>
import { VueDatePicker } from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {ref, watch} from "vue";
import {useTheme} from "../Composables/useTheme.js";

const props = defineProps({
    label: String,
    autocomplete: String,
    modelValue: [String, Array],
    error: String,
    placeholder: {
        type: String,
        default: ""
    },
})

const date = ref(props.modelValue);

const {theme:theme} = useTheme()

const emits = defineEmits(['update:modelValue'])

watch(date, (value) =>{
    emits('update:modelValue', value)
});
</script>

<style>
.dp__theme_dark {
    --dp-background-color: var(--tblr-bg-forms);;
    --dp-text-color: var(--tblr-body-color);
    --dp-hover-color: #484848;
    --dp-hover-text-color: #fff;
    --dp-hover-icon-color: #959595;
    --dp-primary-color: #005cb2;
    --dp-primary-disabled-color: #61a8ea;
    --dp-primary-text-color: #fff;
    --dp-secondary-color: #a9a9a9;
    --dp-border-color: var(--tblr-border-color);
    --dp-menu-border-color: var(--tblr-border-color);;
    --dp-border-color-hover: rgb(130.5, 183, 232);
    --dp-border-color-focus: rgb(130.5, 183, 232);
    --dp-disabled-color: #737373;
    --dp-disabled-color-text: #d0d0d0;
    --dp-scroll-bar-background: #212121;
    --dp-scroll-bar-color: #484848;
    --dp-success-color: #00701a;
    --dp-success-color-disabled: #428f59;
    --dp-icon-color: #959595;
    --dp-danger-color: #e53935;
    --dp-marker-color: #e53935;
    --dp-tooltip-color: #3e3e3e;
    --dp-highlight-color: rgb(0 92 178 / 20%);
    --dp-range-between-dates-background-color: var(--dp-hover-color, #484848);
    --dp-range-between-dates-text-color: var(--dp-hover-text-color, #fff);
    --dp-range-between-border-color: var(--dp-hover-color, #fff);
}

.dp__pointer  {
    font-family: inherit;
    border-radius: var(--tblr-border-radius);
    color: var(--tblr-body-color) !important;
}

.dp__pointer::placeholder {
    color: var(--tblr-body-color) !important;
}

.dp__action_button {
    padding: 1rem;
}
</style>
