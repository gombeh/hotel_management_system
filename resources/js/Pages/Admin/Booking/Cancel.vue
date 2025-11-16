<template>
    <Modal :title="`Cancel Booking #${booking.ref_number}`" formId="cancelForm">
        <form @submit.prevent="submitForm" method="post" id="cancelForm" class="gap-inputs">
            <div>
                <div class="d-flex align-items-end gap-2 mb-2">
                    <div class="flex-grow-1">
                        <BaseInput
                            label="Amount"
                            v-model="form.amount"
                            :error="form.errors.amount"
                            placeholder="amount"
                            :disabled="!is_editing_amount"
                            required
                        />
                    </div>
                    <button type="button"
                            @click="is_editing_amount=true"
                            class="btn btn-success">
                        <IconCalculator class="icon"/>
                        Adjust Fee
                    </button>
                    <button type="button" class="btn btn-warning" @click="form.amount = initial_amount; is_editing_amount=false">
                        <IconRefresh class="icon m-0"/>
                    </button>
                </div>
                <p v-if="penalty_percent === 0">
                    You can cancel this booking for free.
                </p>
                <p v-else>
                    Your penalty percent is <span class="bold fs-3 text-red">{{ penalty_percent }}%</span>
                </p>
            </div>
            <div class="row">
                <base-textarea
                    label="Note"
                    placeholder="some information"
                    v-model="form.description"
                    :error="form.errors.description">
                </base-textarea>
            </div>
            <div class="mt-3 p-3 rounded border">
                <p class="fw-bold mb-2">Cancellation Summary</p>

                <p class="mb-1">
                    <strong>Total Price:</strong>
                    {{ money_format(booking.total_price) }}
                </p>

                <p class="mb-1" v-if="penalty_percent > 0">
                    <strong>Penalty ({{ penalty_percent }}%):</strong>
                    {{ money_format(form.amount) }}
                </p>

                <p class="mb-0">
                    <strong>Refund:</strong>
                    {{ money_format(booking.total_price - form.amount) }}
                </p>
            </div>
        </form>
    </Modal>
</template>
<script setup>
import {useForm} from "@inertiajs/vue3";
import {inject, onMounted, ref, watch} from "vue";
import BaseTextarea from "../../../Components/BaseTextarea.vue";
import BaseInput from "../../../Components/BaseInput.vue";
import Modal from "../../../Components/Modal.vue";
import {IconCalculator, IconRefresh} from '@tabler/icons-vue';
import Swal from "sweetalert2";
import {money_format} from "../../../Utils/helper.js";

const {booking} = defineProps({
    booking: Object
})

const form = useForm({
    amount: '',
    description: '',
});

const closeModal = inject('closeModal');

const is_editing_amount = ref(false)
const penalty_percent = ref(null)
const initial_amount = ref(null)

onMounted(() => {
    axios.get(route('admin.bookings.cancellationFee', booking.id))
        .then(res => {
            const data = res.data;
            form.amount = data.amount;
            initial_amount.value = form.amount
        })
})

const submitForm = () => {
    Swal.fire({
        title: "Are you sure?",
        text: `You are about to cancel this booking. Penalty: ${money_format(form.amount)}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, cancel it",
        cancelButtonText: "No, go back",
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route('admin.bookings.cancel', booking.id), {
                onSuccess: () => closeModal()
            })
        }
    });
}

watch(() => form.amount, (value) => {
    let val = +value;
    if (val === 0) penalty_percent.value = 0

    const percentage = val / booking.total_price * 100;
    penalty_percent.value = Math.round(percentage);
});

</script>
