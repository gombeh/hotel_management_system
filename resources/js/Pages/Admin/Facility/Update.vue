<template>
    <Modal title="Edit Facilities" formId="editFacilityForm">
        <form @submit.prevent="submitEdit" method="post" id="editFacilityForm">
            <div class="mb-3">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    placeholder="name"
                    required
                />
            </div>
            <ImageUploader v-model="form.icon" />
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import ImageUploader from "../../../Components/ImageUploader.vue";

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
