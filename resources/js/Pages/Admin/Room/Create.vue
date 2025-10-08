<template>
    <Modal title="New Rooms" formId="createRoomForm">
        <form @submit.prevent="submitCreate" method="post" id="createRoomForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    type="number"
                    min="1"
                    label="Room Number"
                    v-model="form.room_number"
                    :error="form.errors.room_number"
                    placeholder="Your room number"
                    required/>
            </div>
            <div class="row">
                <select-box
                    label="Room Type"
                    placeholder="Choose Your Room Type"
                    v-model="form.room_type_id"
                    :options="roomTypes"
                    required
                    :error="form.errors.room_type_id" />
            </div>
            <div class="row">
                <BaseInput
                    type="number"
                    min="1"
                    label="Floor Number"
                    v-model="form.floor_number"
                    :error="form.errors.floor_number"
                    placeholder="Your floor number"
                    required/>
            </div>
            <div class="row">
                <select-box
                    label="Status"
                    placeholder="Choose Your Status"
                    v-model="form.status"
                    :options="statuses"
                    required
                    :error="form.errors.status" />
            </div>
            <div class="row">
                <select-box
                    label="Smoking Preference"
                    placeholder="Choose Your Smoking Preference"
                    v-model="form.smoking_preference"
                    :options="smokingPreference"
                    required
                    :error="form.errors.smoking_preference" />
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import SelectBox from "../../../Components/SelectBox.vue";

const {defaultStatus} = defineProps({
    roomTypes: Object,
    statuses: Object,
    defaultStatus: String,
})

const form = useForm({
    room_number: '',
    room_type_id: '',
    floor_number: '',
    status: defaultStatus,
    smoking_preference: '',
});

const smokingPreference = {
    'no_preference': 'No Preference',
    'non_smoking': 'Non Smoking',
    'smoking': 'Smoking',
}

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.rooms.store'), {
        onSuccess: () => closeModal()
    })
}

</script>
