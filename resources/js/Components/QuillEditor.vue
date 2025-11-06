<template>
    <label class="form-label" :class="{'required': $attrs.hasOwnProperty('required')}">{{ label }}</label>
    <QuillEditor
        v-bind="$attrs"
        v-model:content="description" contentType="html"
        :toolbar="toolbarOptions"
        theme="snow"
        class="form-control quill"
    />
    <div class="invalid-feedback d-block" v-if="error">{{ error }}</div>
</template>

<script setup>
import {ref, watch} from 'vue'
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const props = defineProps({
    modelValue: String,
    label: String,
    error: String,
})

const description = ref(props.modelValue)
const emit = defineEmits(['update:modelValue'])


watch(description, (value) => {
    emit('update:modelValue', value)
})

const toolbarOptions = [
    [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
    [{'header': [1, 2, 3, 4, 5, 6, false]}],
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['link', 'image', 'video'],

    [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],
    [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
    [{'direction': 'rtl'}],                         // text direction

    [{'color': []}, {'background': []}],          // dropdown with defaults from theme
    [{'font': []}],
    [{'align': []}],

    ['clean']                                         // remove formatting button
];
</script>

<style>
.ql-toolbar {
    border-radius: var(--tblr-border-radius);
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border: var(--tblr-border-width) solid var(--tblr-border-color) !important;
}

.quill {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    min-height: 150px !important;
    border: var(--tblr-border-width) solid var(--tblr-border-color) !important;
}

.ql-container {
    height: auto;
}
</style>


