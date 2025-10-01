<template>
    <label class="form-check form-switch form-switch-3">
        <input
            type="checkbox"
            class="form-check-input"
            :checked="checked"
            v-model="checked"
            @change="switchInput"
        />
        <span v-if="label" class="form-check-label">{{ label }}</span>
    </label>
</template>

<script setup>
import {ref} from "vue";
import {invertObject, isEmpty} from "../Utils/helper.js";

const props = defineProps({
    modelValue: {
        type: [Boolean, String],
        default: false,
    },
    label: {
        type: String,
        default: "",
    },
    rules: {
        type: Object,
        default: {},
    },
});
const emits = defineEmits(["update:modelValue"]);

const checked = ref(props.rules[props.modelValue] ?? false);

const switchInput = () => {
    const invertRules = invertObject(props.rules);

    const value  = !isEmpty(invertRules) ? invertRules[checked.value] : checked.value;

    emits('update:modelValue', value);
}

</script>
