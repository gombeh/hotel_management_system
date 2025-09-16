<template>
    <Modal title="New Roles" formId="createRoleForm">
        <form @submit.prevent="submitCreate" method="post" id="createRoleForm">
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
import Modal from "../../../Shared/Admin/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Shared/Admin/BaseInput.vue";
import {inject} from "vue";

const form = useForm({
    name: ''
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.roles.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
