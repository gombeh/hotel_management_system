<template>
    <form ref="dropzoneElement" class="dropzone"></form>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";
import {usePage} from "@inertiajs/vue3";

const page = usePage();

Dropzone.autoDiscover = false;

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    maxFile: {
        type: Number,
        default: 1
    }
});
const emit = defineEmits(["update:modelValue"]);

const dropzoneElement = ref(null);
const files = ref(props.modelValue);
let dropzoneInstance = null;

onMounted(() => {
    dropzoneInstance = new Dropzone(dropzoneElement.value, {
        url: route('admin.media.upload'),
        headers: {
            'X-CSRF-TOKEN': page.props.csrf_token
        },
        paramName: "files",
        maxFiles: props.maxFile,
        maxFilesize: 5,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictDefaultMessage: "Drag your file Or choose file",
    });

    dropzoneInstance.on("success", (file, response) => {
        const urls = response.files.map(file => ({
            id: file.path,
            url: file.url,
            new: true
        }));
        files.value.push(...urls);
        emit("update:modelValue", files);

        return urls;
    });

    dropzoneInstance.on("removedfile", (file) => {
        const {url, name} = file;

        files.value = [...files.value.filter(file => {
            if(url) {
                return file.url.trim() !== url.trim()
            }
            const section = file.url.split('/');
            return section[section.length - 1] !== name;
        })];

        if(file.id) {
            console.log(file.id)
            // axios.delete(route('admin.media.delete', file.id));
        }

        emit("update:modelValue", files);
    });

    dropzoneInstance.removeAllFiles(true);
    files.value.forEach((file) => {
        const mockFile = {
            name: file.url.split("/").pop(),
            url: file.url,
            id:file.id,
            size: 12345,
        };
        dropzoneInstance.emit("addedfile", mockFile);
        dropzoneInstance.emit("thumbnail", mockFile, file.url);
        dropzoneInstance.emit("complete", mockFile);
        // dropzoneInstance.files.push(mockFile);


        if (mockFile.previewElement) {
            mockFile.previewElement.classList.add("dz-success", "dz-complete");
        }
    });
});

onBeforeUnmount(() => {
    if (dropzoneInstance) {
        dropzoneInstance.destroy();
        dropzoneInstance = null;
    }
});

</script>

