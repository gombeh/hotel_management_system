<template>
    <Head title="list payments" />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">Payment</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-table">
            <div class="card-header d-block">
                <div class="row w-full">
                    <div class="col">
                        <h3 class="card-title mb-0">Payments</h3>
                        <p class="text-secondary m-0">List Payments.</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <select-box
                            placeholder="All Customers"
                            v-model="filters.customer_id"
                            :options="customers"/>
                    </div>
                    <div class="col-2">
                        <select-box
                            placeholder="All Type"
                            v-model="filters.type"
                            :options="selectType"/>
                    </div>
                    <div class="col-2">
                        <select-box
                            placeholder="All Payment Method"
                            v-model="filters.payment_method"
                            :options="selectMethods"/>
                    </div>
                    <div class="col-2">
                        <select-box
                            placeholder="All Status"
                            v-model="filters.status"
                            :options="selectStatuses"/>
                    </div>
                    <div class="col-2">
                        <DatePicker
                            v-model="filters.paid_at"
                            placeholder="Paid-at"
                            range multi-calendars
                            :time-config="{ enableTimePicker: false }"
                        />
                    </div>
                    <Link :href="route('admin.payments.index')" class="btn btn-primary w-auto">
                        <IconRestore class="icon m-0"/>
                    </Link>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <th>Customer</th>
                        <sort-head name="amount" v-model="sorts" label="Amount"/>
                        <sort-head name="type" v-model="sorts" label="Type"/>
                        <sort-head name="payment_method" v-model="sorts" label="Payment Method"/>
                        <sort-head name="status" v-model="sorts" label="Status"/>
                        <sort-head name="paid_at" v-model="sorts" label="Paid At"/>
                        <sort-head name="created_at" v-model="sorts" label="Created At"/>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr v-for="payment in payments.data" v-if="payments.data.length">
                            <td>
                                <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                       aria-label="Select invoice" value="true">
                            </td>
                            <th>{{ payment.booking.customer.full_name }}</th>
                            <td>{{ money_format(payment.amount) }}</td>
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
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="8" class="text-center">Payments Record Not exists.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <select class="form-select w-auto" v-model="limit" @change="syncFilters">
                    <option value="15" selected>15 records</option>
                    <option value="25">25 records</option>
                    <option value="50">50 records</option>
                    <option value="100">100 records</option>
                </select>
                <Pagination :links="payments.meta.links"/>
            </div>
        </div>
    </div>
    <Update v-if="openModal && editingPayment" :payment="editingPayment" v-bind="{selectMethods, selectStatuses}"/>
</template>

<script setup>
import {provide, ref, toRaw, watch} from "vue";
import {IconEdit, IconRestore,} from '@tabler/icons-vue';
import {useEnum} from "../../../Composables/useEnum.js";
import Update from "../Booking/Payment/Update.vue";
import Pagination from "../../../Shared/Admin/Pagination.vue";
import SortHead from "../../../Components/SortHead.vue";
import {debounce} from "@tabler/core/dist/libs/list.js/src/utils/events.js";
import {router} from "@inertiajs/vue3";
import SelectBox from "../../../Components/SelectBox.vue";
import DatePicker from "../../../Components/DatePicker.vue";
import {money_format} from "../../../Utils/helper.js";


const {types,statuses,methods, ...props} = defineProps({
    customer: Object,
    payments: Object,
    types: Array,
    statuses: Array,
    methods: Array,
    'filters': Object,
    'sorts': String,
    'limit': Number,
    customers: Object,
});

const filters = ref(props.filters);
const sorts = ref(props.sorts);
const limit = ref(props.limit)

const {
    select: selectType,
    display: displayType
} = useEnum(types)

const {
    select: selectMethods,
    display: displayMethod,
} = useEnum(methods)

const {
    select: selectStatuses,
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

watch(filters, debounce(() => {
    syncFilters()
}, 300), {
    deep: true
})


watch(sorts, () => syncFilters());

const syncFilters = () => {
    router.get(route('admin.payments.index'), {
        sorts: sorts.value,
        limit: limit.value,
        filters: toRaw(filters.value)
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
