<template>
    <Modal title="Edit Rooms" formId="editRoomForm">
        <form @submit.prevent="submitEdit" method="post" id="editRoomForm" class="gap-inputs">
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
                    :error="form.errors.room_type_id"/>
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
                    :error="form.errors.status"/>
            </div>
            <div class="row">
                <select-box
                    label="Smoking Preference"
                    placeholder="Choose Your Smoking Preference"
                    v-model="form.smoking_preference"
                    :options="smoking"
                    required
                    :error="form.errors.smoking_preference"/>
            </div>
        </form>
    </Modal>
</template>
<script setup>
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import SelectBox from "../../../Components/SelectBox.vue";


const {room} = defineProps({
    roomTypes: Object,
    room: Object,
    statuses: Object,
    smoking: Object,
})

const form = useForm({
    room_number: room.room_number,
    room_type_id: room.type.id,
    floor_number: room.floor_number,
    status: room.status,
    smoking_preference: room.smoking_preference,
});


const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.rooms.update', room.id), {
        onSuccess: () => closeModal()
    })
}

</script>
