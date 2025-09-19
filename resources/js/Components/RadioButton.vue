<template>
    <label class="form-check form-check-inline" v-for="option in options">
        <input
            class="form-check-input"
            type="radio"
            v-model="localValue"
            :value="option.value"
            id="male">
        <span class="form-check-label" :for="option.value">{{option.label}}</span>
    </label>
</template>

<script setup>
import {defineProps, ref, watch} from "vue";

const props = defineProps({
        options: Array,
        modelValue: String | Number
    })

    const localValue = ref(props.modelValue);

    const emit = defineEmits(['update:modelValue'])

    watch(
        localValue,
        (value) => emit("update:modelValue", value)
    );
</script>
