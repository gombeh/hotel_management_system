<template>
    <Modal title="New Users" formId="createUserForm">
        <form @submit.prevent="submitCreate" method="post" id="createUserForm">
            <div class="row">
                <div class="mb-3 col-lg-6">
                    <BaseInput
                        label="First Name"
                        v-model="form.first_name"
                        :error="form.errors.first_name"
                        placeholder="your name"
                        required
                    />
                </div>
                <div class="mb-3 col-lg-6">
                    <BaseInput
                        label="Last Name"
                        v-model="form.last_name"
                        :error="form.errors.last_name"
                        placeholder="your family"
                        required
                    />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-lg-6">
                    <BaseInput
                        label="Email"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                        placeholder="your email"
                        required
                    />
                </div>
                <div class="mb-3 col-lg-6">
                    <BaseInput
                        label="Password"
                        type="password"
                        v-model="form.password"
                        :error="form.errors.password"
                        placeholder="your password"
                        required
                    />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-lg-6">
                    <SelectBox v-model="form.roles"
                               name="roles"
                               :errors="form.errors"
                               multiple=""
                               label="Select Roles">
                        <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                    </SelectBox>
                </div>
                <div class="mb-3 col-lg-6">
                    <div class="form-label">Sex</div>
                    <RadioButton v-model="form.sex" :options="options"/>
                </div>
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Shared/Admin/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Shared/Admin/BaseInput.vue";
import {inject, defineProps} from "vue";
import RadioButton from "../../../Shared/Admin/RadioButton.vue";
import SelectBox from "../../../Shared/Admin/SelectBox.vue";


defineProps({
    'roles': Object
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    sex: '',
    roles: [],
});

const options = [
    {label: 'Male', value: 'male'},
    {label: 'Female', value: 'female'},
]

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
