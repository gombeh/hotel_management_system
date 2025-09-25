<template>
    <file-pond
        name="imageFilepond"
        ref="pond"
        v-bind:allow-multiple="true"
        accepted-file-types="image/png, image/jpeg"
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
                onerror: () => {}
            },
            remove: handleFilePondRemove,
            revert: handleFilePondRevert
        }"
        v-bind:files="files"
        v-on:init="handleFilePondInit"
    >
    </file-pond>
</template>

<script setup>
import { ref} from "vue";
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    allowMultiple: {
        type: Boolean,
        default: false,
    },
    isUpdate: {
        type: Boolean,
        default: false
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
    files.value = [];

    files.value = props.modelValue.map((url) => ({
        source: '/' + url,

        options: {
            type: 'local',
            metadata: {
                poster: '/' + url
            }
        }
    }))
}

const addFormImage = (images) => {
    files.value.push(...images);
    emit('update:modelValue', files.value)
}

// const removeFormImage = (image) => {
//     let arr = this.form.image ? this.form.image.split('|') : [];
//     arr.remove(image);
//     this.form.image = arr.join('|');
//     console.log(this.form.image);
// }

const handleFilePondRemove = () => {}
const handleFilePondRevert = () => {}

const handleFilePondLoad = (response) => {
    response.blob().then(function(myBlob) {
        load(myBlob);
    });
}

</script>
