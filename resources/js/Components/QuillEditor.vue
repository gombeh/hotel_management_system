<template>
    <div class="mb-3 position-relative">
        <label class="form-label">{{ label }}</label>

        <QuillEditor
            v-model:content="description" contentType="html"
            :toolbar="toolbarOptions"
            theme="snow"
            class="form-control quill"
        />
    </div>
</template>

<script setup>
import {ref, watch} from 'vue'
import {QuillEditor} from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

const props = defineProps({
    modelValue: String,
    label: String,
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
}

.quill {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    min-height: 150px !important;
}

.ql-container {
    height: auto;
}
</style>


