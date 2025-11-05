<template>
    <Head title="change password"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">Change Password</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.dashboard')">
                <IconArrowLeft class="icon"/>
                Back
            </Link>
        </div>
    </div>
    <div class="row">
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
    form.put(route('admin.password.update'), {
        onSuccess: () => {
            form.reset();
        }
    });
}
</script>
