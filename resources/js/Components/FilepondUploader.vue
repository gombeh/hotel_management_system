<template>
    <label class="form-label" :class="{'required': $attrs.hasOwnProperty('required')}">{{ label }}</label>
    <file-pond
        v-bind="$attrs"
        name="imageFilepond"
        ref="pond"
        :class="{'filepond--multiple': allowMultiple}"
        v-bind:allow-multiple="true"
        accepted-file-types="image/png, image/jpeg"
        :maxFiles="maxFiles"
        :allow-reorder="allowReorder"
        @reorderfiles="handleReorder"
        v-bind:server="{
        url: '',
        timeout: 7000,
        process:{
            url: route('admin.media.upload'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $page.props.csrf_token
            },
            withCredentials: false,
            onload: handleFilePondLoad,
        },
        load: handleFilePondLoaded,
        remove: handleFilePondRemove,
        revert: handleFilePondRevert
    }"
        v-bind:files="files"
        v-on:init="handleFilePondInit"
    >
    </file-pond>
    <div class="invalid-feedback d-block" v-if="error">{{ error }}</div>
</template>

<script setup>
import {ref} from "vue";
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import {router} from '@inertiajs/vue3'
import {isString} from "../Utils/helper.js";


const props = defineProps({
    label: String,
    modelValue: {
        type: Array,
        default: () => [],
    },
    allowMultiple: {
        type: Boolean,
        default: false,
    },
    allowReorder: {
        type: Boolean,
        default: false,
    },
    maxFiles: {
        type: Number,
        default: 1
    },
    hasNeedReload: {
        type: Boolean,
        default: true
    },
    error: {
        type: String,
        default: ""
    }
});

const files = ref([]);
const pond = ref(null);


const emit = defineEmits(["update:modelValue"]);

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

const handleFilePondInit = () => {
    files.value = props.modelValue.map((image) => ({
        source: image.url,

        options: {
            type: 'local',
            serverId: image.id,
            metadata: {
                url: image.url,
            },
            path: image.url,
        }
    }))

    emit('update:modelValue', [])
}

const addFormImage = (image) => {
    files.value.push({
        source: image.url,
        options: {
            type: 'local',
            metadata: {
                poster: image.url
            },
            path: image.path
        }
    });
    emit('update:modelValue', [...props.modelValue, image.path])
}

const removeFormImage = (image) => {  //todo fix bug sorted image delete and de sort that in create
    let removedId
    files.value = files.value.filter(img => {
        const result = img.options.path.trim() !== image.trim()

        if (!result) {
            removedId = img.options.serverId
        }
        return result
    })

    if (removedId) {
        axios.delete(route('admin.media.delete', removedId), {
            media: removedId
        });

        props.hasNeedReload && router.reload();
    }

    emit('update:modelValue', props.modelValue.filter(img => {
        if (!isString(image)) return true;
        return img.trim() !== image.trim()
    }))
}

const handleFilePondRemove = (source, load, error) => {
    removeFormImage(source);
    load();
}

const handleFilePondRevert = (uniqueId, load, error) => {
    removeFormImage(uniqueId);
    load();
}

const handleFilePondLoad = (response) => {
    const data = JSON.parse(response);
    const image = data.file;

    addFormImage(image);

    return image.path;
}

const handleReorder = (fileItems) => {
    const items = fileItems.map(fileItem => {
        const file = files.value.find(file => [file.options.path, file.source].includes(fileItem.serverId));
        return file?.options.serverId ?? file?.options.path ?? null;
    }).map(fileItem => fileItem)

    items.length && emit('update:modelValue', items);
};

const handleFilePondLoaded = (source, load, error, progress, abort, headers) => {
    fetch(source)
        .then(res => {
            if (!res.ok) {
                error('خطا در بارگیری فایل: ' + res.statusText);
                return;
            }
            return res.blob();
        })
        .then(myBlob => {
            load(myBlob);
        })
        .catch(err => {
            error(err.message);
        });

    return {
        abort: () => {
            abort();
        }
    };
}

</script>

<style>
.filepond--root {
    margin: 0 !important;
}

.filepond--multiple .filepond--list {
    display: flex !important;
    flex-wrap: wrap;
    gap: 10px;
}

.filepond--multiple .filepond--item {
    width: calc(24.99% - 0.5em);
    height: 200px !important;
    overflow: hidden;
    border-radius: 5px;
}

</style>
