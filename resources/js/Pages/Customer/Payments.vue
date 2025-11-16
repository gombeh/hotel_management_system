<template>
    <div class="container">
        <Head title="list payments"/>
        <div class="row g-2 align-items-center mb-4">
            <div class="col">
                <h2 class="page-title">Payments</h2>
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
                            <th>
                                Booking
                            </th>
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
                        </tr>
                        </thead>
                        <tbody class="table-tbody">
                        <tr v-for="payment in payments" v-if="payments.length">
                            <td>
                                <Link :href="route('bookings.success', payment.booking.id)">
                                    #{{payment.booking.ref_number}}
                                </Link>
                            </td>
                            <td>{{ number_format(payment.amount) }}</td>
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
                        </tr>
                        <tr v-else>
                            <td colspan="8" class="text-center">Payments Record Not exists.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useEnum} from "../../Composables/useEnum.js";
import {number_format} from "../../Utils/helper.js";

const {types, statuses, methods} = defineProps({
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
    display: displayMethod,
} = useEnum(methods)

const {
    display: displayStatus,
} = useEnum(statuses)

</script>
