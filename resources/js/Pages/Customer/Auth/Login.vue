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
                            <h4>Login</h4>
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
                                <div class="form-group full-width mb-0">
                                    <label for="password" class="form-label required">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="1234"
                                           v-model="form.password"
                                           :class="{'is-invalid': form.errors.password}"
                                           required="">
                                    <div class="invalid-feedback" v-show="form.errors.password"
                                         v-text="form.errors.password"></div>
                                </div>
                                <div class="form-group full-width mb-0">
                                    <label class="form-check">
                                        <input v-model="form.remember" type="checkbox" class="form-check-input"/>
                                        <span class="form-check-label">Remember me on this device</span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <div>
                                    Don’t have an account yet? <Link :href="route('registerForm')">register</Link>
                                </div>
                                <div>
                                    <Link :href="route('password.request')">I forgot password</Link>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-unlock me-2" style="font-size: 18px"></i>
                                Login
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
    password: '',
    remember: false
})

const submitLogin = () => {
    form.post(route('login'));
}
</script>

