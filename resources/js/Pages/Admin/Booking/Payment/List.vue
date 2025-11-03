<template>
    <Head title="list payments booking" />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">list payments booking  ({{booking.customer.full_name}})</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <button v-if="access.createPayment" class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    New Record
                </button>
                <Link class="btn btn-1" :href="route('admin.bookings.index')">
                    <IconArrowLeft class="icon"/>
                    Back
                </Link>
            </div>
            <!-- BEGIN MODAL -->
            <!-- END MODAL -->
        </div>
    </div>

    <div class="card">
        <div class="card-table">
            <div class="card-header">
                <div class="row w-full">
                    <div class="col">
                        <h3 class="card-title mb-0">Payments</h3>
                        <p class="text-secondary m-0">List Payments.</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <th>
                            amount
                        </th>
                        <th>
                            type
                        </th>
                        <th>payment method</th>
                        <th>status</th>
                        <th>paid_at</th>
                        <th>created At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr v-for="payment in payments" v-if="payments.length">
                            <td>
                                <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                       aria-label="Select invoice" value="true">
                            </td>
                            <td>${{ payment.amount }}</td>
                            <td>
                                <span class="badge" :class="displayType(payment.type).bgClass">
                                    {{ displayType(payment.type).label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge" :class="displayMethod(payment.payment_method).bgClass">
                                {{ displayMethod(payment.payment_method).label }}
                            </span>
                            </td>
                            <td>
                                <span class="badge" :class="displayStatus(payment.status).bgClass">
                                {{ displayStatus(payment.status).label }}
                            </span>
                            </td>
                            <td>{{ payment.paid_at ?? '-' }}</td>
                            <td>{{ payment.created_at }}</td>
                            <td class="text-end">
                                <div class="dropdown" v-if="Object.values(payment.access).some(per => per)">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                        <button class="dropdown-item align-middle"
                                                @click="openEditModal(payment)"
                                                v-if="payment.access.edit">
                                            <IconEdit class="icon icon1"/>
                                            Edit
                                        </button>
                                        <button class="dropdown-item"
                                                @click="() => confirmDelete(route('admin.payments.destroy', payment.id))"
                                                v-if="payment.access.delete">
                                            <IconTrash class="icon icon1"/>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="7" class="text-center">Payments Record Not exists.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <Create v-if="openModal && !editingPayment" :booking_id="booking.id" v-bind="{selectMethods, selectStatuses, defaultStatus}"/>
    <Update v-if="openModal && editingPayment" :payment="editingPayment" v-bind="{selectMethods, selectStatuses}"/>
</template>

<script setup>
import {provide, ref} from "vue";
import Create from "./Create.vue";
import {IconEdit, IconTrash, IconPlus, IconArrowLeft} from '@tabler/icons-vue';
import Update from "./Update.vue";
import {useConfirm} from "../../../../Composables/useConfirm.js";
import {useEnum} from "../../../../Composables/useEnum.js";

const confirmDelete = useConfirm();

const {types,statuses,methods} = defineProps({
    booking: Object,
    payments: Array,
    types: Array,
    statuses: Array,
    methods: Array,
    access: Object,
});

const {
    display: displayType
} = useEnum(types)

const {
    select: selectMethods,
    display: displayMethod,
} = useEnum(methods)

const {
    select: selectStatuses,
    default: defaultStatus,
    display: displayStatus,
} = useEnum(statuses)

let editingPayment = ref(null);
let openModal = ref(false);

provide("closeModal", () => {
    openModal.value = false
    if(editingPayment) editingPayment.value = null
});

const openEditModal = (payment) => {
    editingPayment.value = payment;
    openModal.value = true
}

</script>
