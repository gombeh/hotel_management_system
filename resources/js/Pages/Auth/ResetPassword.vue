<template>
    <section id="booking" class="booking h-fullscreen">
        <div class="d-flex justify-content-center mt-6 h-full">
            <div class="booking-form-section" style="width: 600px">
                <div class="form-container w-full">
                    <form class="reservation-form" @submit.prevent="submitForm" method="POST">
                        <div class="form-section mb-3">
                            <h4>Reset Password</h4>
                            <div class="form-grid">
                                <div class="form-group full-width mb-0">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" class="form-control" id="email"
                                           v-model="form.email"
                                           :class="{'is-invalid': form.errors.email}"
                                           placeholder="first name" required="">
                                    <div class="invalid-feedback" v-show="form.errors.email"
                                         v-text="form.errors.email"></div>
                                </div>
                                <div class="form-group full-width mb-0">
                                    <label for="password" class="form-label required">Password</label>
                                    <input type="password" class="form-control" id="password"
                                           v-model="form.password"
                                           :class="{'is-invalid': form.errors.password}"
                                           placeholder="1234" required="">
                                    <div class="invalid-feedback" v-show="form.errors.password"
                                         v-text="form.errors.password"></div>
                                </div>
                                <div class="form-group full-width mb-0">
                                    <label for="password_confirm" class="form-label required">Password Confirm</label>
                                    <input type="password" class="form-control" id="password_confirm"
                                           v-model="form.password_confirmation"
                                           :class="{'is-invalid': form.errors.password_confirmation}"
                                           placeholder="1234" required="">
                                    <div class="invalid-feedback" v-show="form.errors.password_confirmation"
                                         v-text="form.errors.password_confirmation"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-unlock2 me-2" style="font-size: 18px"></i>
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {useForm} from "@inertiajs/vue3";

const {email, token} = defineProps({
    email: '',
    token: '',
})

const form = useForm({
    email: email,
    token: token,
    password: '',
    password_confirmation: '',
})

const submitForm = () => {
    form.post(route('password.update'));
}
</script>

