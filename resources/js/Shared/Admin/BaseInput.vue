<template>
    <div class="mb-3">
        <label v-if="label" class="form-label">{{ label }}</label>
        <input
            v-bind="$attrs"
            :type="type"
            class="form-control"
            :class="{ 'is-invalid': error }"
            :placeholder="placeholder"
            :autocomplete="autocomplete"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <div class="invalid-feedback" v-if="error">
            {{ error }}
        </div>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    type: {
        type: String,
        default: 'text'
    },
    placeholder: String,
    autocomplete: String,
    modelValue: String, // for v-modal
    error: String
})

defineEmits(['update:modelValue'])
</script>
