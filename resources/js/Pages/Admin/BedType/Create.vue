<template>
    <Modal title="New Bed Types" formId="createBedTypeForm">
        <form @submit.prevent="submitCreate" method="post" id="createBedTypeForm">
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
<script setup>
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";

const form = useForm({
    name: '',
    capacity: '',
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.bedTypes.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
