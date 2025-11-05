<template>
    <Head title="edit profile"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">Edit Profile</h2>
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
                            <filepond-uploader
                                label="Avatar"
                                v-model="form.avatar"
                                :error="form.errors.avatar"
                                :hasNeedReload="false"/>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-label">Sex</div>
                            <RadioButton v-model="form.sex" :options="selectSexes"/>
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
import {IconDeviceFloppy, IconArrowLeft} from '@tabler/icons-vue';

const page = usePage();

const {user, sexes} = defineProps({
    user: Object,
    sexes: Array
})

const {select: selectSexes} = useEnum(sexes);

const form = useForm({
    first_name: user.first_name,
    last_name: user.last_name,
    sex: user.sex,
    avatar: user.avatar,
});

const handleForm = () => {
    form.put(route('admin.profile.update'));
}
</script>
