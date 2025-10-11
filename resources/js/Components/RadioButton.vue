<template>
    <label class="form-check form-check-inline" v-for="[id, label] in Object.entries(options)">
        <input
            class="form-check-input"
            type="radio"
            v-model="localValue"
            :value="id"
            :id="id">
        <span class="form-check-label" :for="id">{{label}}</span>
    </label>
</template>

<script setup>
import {defineProps, ref, watch} from "vue";

const props = defineProps({
        options: Object,
        modelValue: String | Number
    })

    const localValue = ref(props.modelValue);

    const emit = defineEmits(['update:modelValue'])

    watch(
        localValue,
        (value) => emit("update:modelValue", value)
    );
</script>
