<template>
    <section id="booking" class="booking h-fullscreen">
        <div class="d-flex justify-content-center mt-6 h-full">
            <div class="booking-form-section" style="width: 600px">
                <div class="form-container w-full">
                    <form class="reservation-form" @submit.prevent="submitLogin" method="POST">
                        <div class="form-section mb-3">
                            <h4>Verify Code</h4>
                            <div class="form-grid">
                                <div class="form-group full-width mb-0">
                                    <label for="email" class="form-label required">Code</label>
                                    <input type="text" class="form-control" id="email"
                                           v-model="form.code"
                                           :class="{'is-invalid': form.errors.code}"
                                           placeholder="example@gmail.com" required="">
                                    <div class="invalid-feedback" v-show="form.errors.code"
                                         v-text="form.errors.code"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5">
                                <div>
                                    <Link class="btn btn-link p-0" :href="route('resendCode')" method="POST" as="button">Request New Code</Link>
                                </div>
                                <div>
                                    <Link class="btn btn-link p-0" :href="route('backRegister')" method="POST" as="button">Back to sign-up</Link>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-shield-lock me-2" style="font-size: 18px"></i>
                                Verify Code
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

const form = useForm({
    code: '',
})

const submitLogin = () => {
    form.post(route('verifyCode'));
}
</script>

