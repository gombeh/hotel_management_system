<template>
    <label v-if="label"
           :class="{'required': $attrs.hasOwnProperty('required')}"
           class="form-label">
        {{ label }}
    </label>
    <textarea
        v-bind="$attrs"
        class="form-control"
        :class="{ 'is-invalid': error }"
        :placeholder="placeholder"
        :autocomplete="autocomplete"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
    </textarea>
    <div class="invalid-feedback" v-if="error">
        {{ error }}
    </div>
</template>

<script setup>
defineProps({
    label: String,
    placeholder: String,
    autocomplete: String,
    modelValue: String,
    error: String
})

defineEmits(['update:modelValue'])
</script>
