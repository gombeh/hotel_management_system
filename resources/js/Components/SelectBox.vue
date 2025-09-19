<template>
    <div class="form-label">Select Roles</div>
    <select class="form-select"
            :class="{ 'is-invalid':modelError.length}"
            v-bind="$attrs"
            :id="name"
            v-model="localValue">
        <slot/>
    </select>
    <div class="invalid-feedback" v-if="modelError.length">
        {{ errors[modelError[0]] }}
    </div>
</template>

<script setup>
import {computed, defineProps, ref, watch} from 'vue'
import {wildCardProperty} from "../Utils/helper.js";

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
    errors: {
        type: Object,
        default: () => ({})
    },
})
const localValue = ref(props.modelValue);
const emit = defineEmits(['update:modelValue'])

const modelError = computed(() => wildCardProperty(props.errors, new RegExp(`^${props.name}.\\d+$`)));

watch(localValue, (value) => emit('update:modelValue', value))

</script>
