<template>
    <Modal title="New Payments" formId="createPaymentForm">
        <form @submit.prevent="submitCreate" method="post" id="createPaymentForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    label="Amount"
                    v-model="form.amount"
                    :error="form.errors.amount"
                    placeholder="amount"
                    required
                />
            </div>
            <div class="row">
                <select-box
                    label="Method"
                    placeholder="Choose Your Payment Method"
                    :options="selectMethods"
                    v-model="form.payment_method"
                    :error="form.errors.payment_method"
                    required>
                </select-box>
            </div>
            <div class="row">
                <select-box
                    label="Status"
                    placeholder="Choose Your Payment Status"
                    :options="selectStatuses"
                    v-model="form.status"
                    :error="form.errors.status"
                    required>
                </select-box>
            </div>
            <div class="row">
                <div class="row">
                    <BaseInput
                        label="Reference"
                        v-model="form.reference"
                        :error="form.errors.reference"
                        placeholder="reference"
                        />
                </div>
            </div>
            <div class="row">
                <base-textarea
                    label="Note"
                    placeholder="some information"
                    v-model="form.note"
                    :error="form.errors.note">
                </base-textarea>
            </div>
        </form>
    </Modal>
</template>
<script setup>
import {useForm} from "@inertiajs/vue3";
import {inject} from "vue";
import Modal from "../../../../Components/Modal.vue";
import BaseInput from "../../../../Components/BaseInput.vue";
import SelectBox from "../../../../Components/SelectBox.vue";
import BaseTextarea from "../../../../Components/BaseTextarea.vue";

const {booking_id, defaultStatus} = defineProps({
    'booking_id': Number,
    selectMethods: Object,
    selectStatuses: Object,
    defaultStatus: String,
})

const form = useForm({
    amount: '',
    payment_method: '',
    status: defaultStatus,
    reference: '',
    note: '',
});

const closeModal = inject('closeModal');
const submitCreate = () => {
    form.post(route('admin.bookings.payments.store', booking_id), {
        onSuccess: () => closeModal()
    })
}

</script>
