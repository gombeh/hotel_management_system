<template>
    <div class="container">
        <Head title="edit profile"/>
        <div class="row g-2 align-items-center mb-2">
            <div class="col">
                <h2 class="page-title text-capitalize">Edit Profile</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Edit Profile</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleForm"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                label="First Name"
                                v-model="form.first_name"
                                :error="form.errors.first_name"
                                required
                                placeholder="Your first name"/>
                        </div>

                        <div class="col-6">
                            <base-input
                                label="Last Name"
                                v-model="form.last_name"
                                :error="form.errors.last_name"
                                required
                                placeholder="Your last name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                label="Mobile"
                                v-model="form.mobile"
                                :error="form.errors.mobile"
                                placeholder="Your mobile"/>
                        </div>

                        <div class="col-6">
                            <select-box
                                label="National"
                                placeholder="Choose Your national"
                                :options="countries"
                                v-model="form.national_id"
                                :error="form.errors.national_id">
                            </select-box>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="date"
                                label="Birthdate"
                                v-model="form.birthdate"
                                :error="form.errors.birthdate"
                                placeholder="Your mobile"/>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-label">Sex</div>
                            <RadioButton v-model="form.sex" :options="selectSexes"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <filepond-uploader
                                label="Avatar"
                                v-model="form.avatar"
                                :error="form.errors.avatar"
                                :hasNeedReload="false"/>
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
import {defineProps} from "vue"
import {useForm, usePage} from "@inertiajs/vue3";
import FilepondUploader from "../../../Components/FilepondUploader.vue";
import BaseInput from "../../../Components/BaseInput.vue";
import RadioButton from "../../../Components/RadioButton.vue";
import {useEnum} from "../../../Composables/useEnum.js";
import {IconDeviceFloppy} from '@tabler/icons-vue';
import SelectBox from "../../../Components/SelectBox.vue";

const page = usePage();

const {customer, sexes} = defineProps({
    customer: Object,
    sexes: Array,
    countries: Object,
})

const {select: selectSexes} = useEnum(sexes);

const form = useForm({
    first_name: customer.first_name,
    last_name: customer.last_name,
    sex: customer.sex ?? '',
    avatar: customer.avatar,
    national_id: customer.national?.id ?? '',
    mobile: customer.mobile ?? '',
    birthdate: customer.birthdate ?? '',
});

const handleForm = () => {
    form.put(route('customer.profile.update'));
}
</script>
