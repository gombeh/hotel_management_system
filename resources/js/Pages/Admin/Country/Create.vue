<template>
    <Modal title="New Countries" formId="createCountryForm">
        <form @submit.prevent="submitCreate" method="post" id="createCountryForm">
            <div class="mb-3">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    placeholder="your name"
                    required
                />
            </div>
            <div class="mb-3">
                <BaseInput
                    label="Short"
                    v-model="form.short"
                    :error="form.errors.short"
                    placeholder="your short"
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

const form = useForm({
    name: '',
    short: '',
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.countries.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
