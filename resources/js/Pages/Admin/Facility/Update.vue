<template>
    <Modal title="Edit Facilities" formId="editFacilityForm">
        <form @submit.prevent="submitEdit" method="post" id="editFacilityForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    placeholder="name"
                    required
                />
            </div>
            <div class="row">
                <FilepondUploader v-model="form.icon" label="Icon"/>
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import FilepondUploader from "../../../Components/FilepondUploader.vue";

const {facility} = defineProps({
    facility: Object
})

const form = useForm({
    name: facility.name,
    icon: facility.icon,
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.facilities.update', facility.id), {
        onSuccess: () => closeModal()
    })
}

</script>
