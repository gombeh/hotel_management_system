<template>
    <Modal title="Edit Bed Types" formId="editBedTypesForm">
        <form @submit.prevent="submitEdit" method="post" id="editBedTypesForm">
            <div class="mb-3">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    placeholder="name"
                    required
                />
            </div>
            <div class="mb-3">
                <BaseInput
                    label="Capacity"
                    type="number"
                    min="1"
                    max="2"
                    v-model="form.capacity"
                    :error="form.errors.capacity"
                    placeholder="your capacity"
                    required
                />
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";

const {bedType} = defineProps({
    bedType: Object
})

const form = useForm({
    name: bedType.name,
    capacity: bedType.capacity,
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.bedTypes.update', bedType.id), {
        onSuccess: () => closeModal()
    })
}

</script>
