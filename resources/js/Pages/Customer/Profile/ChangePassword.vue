<template>
    <div class="container">
        <Head title="change password"/>
        <div class="row g-2 align-items-center mb-2">
            <div class="col">
                <h2 class="page-title text-capitalize">Change Password</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Change Password</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleForm"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="password"
                                label="Current Password"
                                v-model="form.current_password"
                                :error="form.errors.current_password"
                                required
                                placeholder="current password"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="password"
                                label="Password"
                                v-model="form.password"
                                :error="form.errors.password"
                                required
                                placeholder="password"/>
                        </div>
                        <div class="col-6">
                            <base-input
                                type="password"
                                label="Password Confirmation"
                                v-model="form.password_confirmation"
                                :error="form.errors.password_confirmation"
                                required
                                placeholder="password confirmation"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary ms-auto" form="createRoomTypes">
                    <IconDeviceFloppy class="icon"/>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {IconDeviceFloppy, IconArrowLeft} from '@tabler/icons-vue';

const page = usePage();

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const handleForm = () => {
    form.post(route('customer.password.save'), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
