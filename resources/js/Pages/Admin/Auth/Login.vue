<template>
    <header>
        <title>Login - admin panel</title>
    </header>
    <div class="page page-center h-fullscreen">
        <div class="container container-normal py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg">
                    <div class="container-tight">
                        <div class="text-center mb-4">
                            <img width="70" src="/resources/images/Homa.png" alt="logo"/> <span
                            class="bold h3">Hotel Homa</span>
                        </div>

                        <div class="card card-md">
                            <div class="card-body">
                                <h2 class="h2 text-center mb-4">Login to your account</h2>
                                <form method="post" @submit.prevent="submitLogin" autocomplete="off" novalidate="">
                                    <div class="mb-3">
                                        <BaseInput
                                            label="Email address"
                                            v-model="form.email"
                                            :error="form.errors.email"
                                            placeholder="your@email.com"
                                            required />
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Password
                                            <span class="form-label-description">
                                                <a href="./forgot-password.html">I forgot password</a>
                                             </span>
                                        </label>
                                        <div class="input-group input-group-flat">
                                            <input type="text" v-model="form.password"
                                                   v-if="showPassword"
                                                   class="form-control"
                                                   :class="{'is-invalid': form.errors.password}"
                                                   placeholder="Your password"
                                                   autocomplete="off"/>
                                            <input type="password" v-model="form.password"
                                                   v-else
                                                   class="form-control"
                                                   :class="{'is-invalid': form.errors.password}"
                                                   placeholder="Your password"
                                                   autocomplete="off"/>
                                            <span class="input-group-text"
                                                  :class="{'invalid-extra-input': form.errors.password}">
                                                 <a href="#" class="link-secondary"
                                                    data-bs-original-title="Show password" @click="toggleShow">
                                                    <IconEye :class="{'show-eyes': showPassword}" class="icon"/>
                                                 </a>
                                            </span>
                                            <div class="invalid-feedback" v-show="form.errors.password"
                                                 v-text="form.errors.password"></div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-check">
                                            <input v-model="form.remember" type="checkbox" class="form-check-input"/>
                                            <span class="form-check-label">Remember me on this device</span>
                                        </label>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg d-none d-lg-block">
                    <LoginIcon/>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import LoginIcon from "../../../Components/Svg/LoginIcon.vue";
import {IconEye} from '@tabler/icons-vue'
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import BaseInput from "../../../Components/BaseInput.vue";

defineOptions({ layout: null })


let showPassword = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false
})

const toggleShow = () => {
    showPassword.value = !showPassword.value
}
const submitLogin = () => {
    form.post(route('admin.login'));
}
</script>
