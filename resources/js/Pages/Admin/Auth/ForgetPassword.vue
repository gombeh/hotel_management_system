<template>
    <div class="page page-center h-fullscreen">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <img width="70" src="/resources/images/Homa.png" alt="logo"/> <span
                class="bold h3 brand-color">Hotel Homa</span>
            </div>
            <div class="alert alert-success" role="alert" v-if="flash?.message">
                {{ flash.message }}
            </div>
            <form class="card card-md" @submit.prevent="submitForm" autocomplete="off">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Forgot password</h2>
                    <p class="text-secondary mb-4">Enter your email address and your password will be reset and emailed to you.</p>
                    <div class="mb-3">
                        <base-input
                            label="Email address"
                            v-model="form.email"
                            :error="form.errors.email"
                            placeholder="Enter email"
                            required/>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-4 w-100">
                            <IconMail class="icon icon-2" />
                            Send me new password
                        </button>
                    </div>
                </div>
            </form>
            <div class="text-center text-secondary mt-3">Forget it, <Link :href="route('admin.login')">send me back</Link> to the sign in screen.</div>
        </div>
    </div>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import "@tabler/core/dist/css/tabler.min.css";
import {IconMail} from '@tabler/icons-vue';

defineOptions({ layout: null })

const {flash} = defineProps({
    flash: {}
})

const form = useForm({
    email: '',
})

const submitForm = () => {
    form.post(route('admin.password.email'));
}
</script>

