<template>
    <Modal title="Edit Customer" formId="editCustomerForm">
        <form @submit.prevent="submitEdit" method="post" id="editCustomerForm"  class="gap-inputs">
            <div class="row">
                <div class="col-lg-6">
                    <BaseInput
                        label="First Name"
                        v-model="form.first_name"
                        :error="form.errors.first_name"
                        placeholder="your name"
                        required
                    />
                </div>
                <div class="col-lg-6">
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
                <div class="col-lg-6">
                    <BaseInput
                        label="Email"
                        type="email"
                        v-model="form.email"
                        :error="form.errors.email"
                        placeholder="your email"
                        required
                    />
                </div>
                <div class="col-lg-6">
                    <BaseInput
                        label="Mobile"
                        v-model="form.mobile"
                        :error="form.errors.mobile"
                        placeholder="your mobile"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <BaseInput
                        label="Password"
                        type="password"
                        v-model="form.password"
                        :error="form.errors.password"
                        placeholder="your password"
                    />
                </div>
                <div class="col-lg-6">
                    <div class="form-label">Sex</div>
                    <RadioButton v-model="form.sex" :options="sexes"/>
                </div>
            </div>
            <div class="row px-2">
                <base-switch
                    label="Status"
                    v-model="form.status"
                    :rules="statuses"/>
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import RadioButton from "../../../Components/RadioButton.vue";
import BaseSwitch from "../../../Components/BaseSwitch.vue";


const {customer} = defineProps({
    customer: Object,
    sexes: Object,
    statuses: Object,
})

const form = useForm({
    first_name: customer.first_name,
    last_name: customer.last_name,
    email: customer.email,
    mobile: customer.mobile,
    password: '',
    sex: customer.sex,
    status: customer.status
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.customers.update', customer.id), {
        onSuccess: () => closeModal()
    })
}

</script>
