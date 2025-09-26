<template>
    <Modal title="New Facilities" formId="createFacilityForm">
        <form @submit.prevent="submitCreate" method="post" id="createFacilityForm">
            <div class="mb-3">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    placeholder="name"
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
    icon: [],
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.facilities.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
