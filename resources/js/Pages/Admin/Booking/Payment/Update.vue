<template>
    <Modal title="Edit Payments" formId="editPaymentsForm">
        <form @submit.prevent="submitEdit" method="post" id="editPaymentsForm" class="gap-inputs">
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
<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import {inject} from "vue";
import BaseInput from "../../../../Components/BaseInput.vue";
import SelectBox from "../../../../Components/SelectBox.vue";
import BaseTextarea from "../../../../Components/BaseTextarea.vue";
import Modal from "../../../../Components/Modal.vue";

const {payment} = defineProps({
    payment: Object,
    selectMethods: Object,
    selectStatuses: Object,
})

const form = useForm({
    amount: payment.amount,
    payment_method: payment.payment_method,
    status: payment.status,
    reference: payment.reference,
    note: payment.note,
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.payments.update', payment.id), {
        onSuccess: () => {
            closeModal();
        }
    })
}

</script>
