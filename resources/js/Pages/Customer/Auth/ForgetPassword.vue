<template>
    <section id="booking" class="booking h-fullscreen">
        <div class="d-flex justify-content-center mt-6 h-full">
            <div class="booking-form-section" style="width: 600px">
                <div class="alert alert-success" role="alert" v-if="flash?.message">
                    {{ flash.message }}
                </div>
                <div class="form-container w-full">
                    <form class="reservation-form" @submit.prevent="submitLogin" method="POST">
                        <div class="form-section mb-3">
                            <h4>Forget Password</h4>
                            <div class="form-grid">
                                <div class="form-group full-width mb-0">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" class="form-control" id="email"
                                           v-model="form.email"
                                           :class="{'is-invalid': form.errors.email}"
                                           placeholder="example@gmail.com" required="">
                                    <div class="invalid-feedback" v-show="form.errors.email"
                                         v-text="form.errors.email"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    Already have an account? <Link :href="route('loginForm')">Login</Link>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-lock me-2" style="font-size: 18px"></i>
                                Forget Password
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

const {flash} = defineProps({
    flash: {}
})

const form = useForm({
    email: '',
})

const submitLogin = () => {
    form.post(route('password.email'));
}
</script>

