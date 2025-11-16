<template>
    <Head title="show booking"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">{{ booking.full_name }} Booking</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.bookings.index')">
                <IconArrowLeft class="icon"/>
                Back
            </Link>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row g-2 align-items-center w-full my-2">
                    <span class="col m-0">Base info</span>
                </div>
            </div>
            <div class="card-body py-5 px-3">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Ref Number</div>
                        <div class="datagrid-content">{{ booking.ref_number }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Full Name</div>
                        <div class="datagrid-content">
                            <Link :href="route('admin.customers.show', booking.customer.id)">
                                {{ booking.customer.full_name }}
                            </Link>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Adults</div>
                        <div class="datagrid-content">{{ booking.adults }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Children</div>
                        <div class="datagrid-content">{{ booking.children ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Check In</div>
                        <div class="datagrid-content">{{ booking.check_in }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Check Out</div>
                        <div class="datagrid-content">{{ booking.check_out }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Meal Plan</div>
                        <div class="datagrid-content">{{ booking.mealPlan.name }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Status</div>
                        <div class="datagrid-content">
                            <span class="badge" :class="displayStatus(booking.status).bgClass">
                                {{ displayStatus(booking.status).label }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Payment Status</div>
                        <div class="datagrid-content">
                            <Link :href="route('admin.bookings.payments.index', booking.id)">
                             <span class="badge" :class="displayPaymentStatus(booking.payment_status).bgClass">
                                {{ displayPaymentStatus(booking.payment_status).label }}
                            </span>
                            </Link>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Smoking Preference</div>
                        <div class="datagrid-content">
                            <span class="badge" :class="displaySmoking(booking.smoking_preference).bgClass">
                                {{ displaySmoking(booking.smoking_preference).label }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Total Price</div>
                        <div class="datagrid-content">
                            {{ number_format(booking.total_price) }}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Deposit Amount</div>
                        <div class="datagrid-content">
                            {{ number_format(booking.deposit_amount) }}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Created At</div>
                        <div class="datagrid-content">{{ booking.created_at }}</div>
                    </div>
                </div>
                <div class="datagrid mt-4">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Special Requests</div>
                        <div class="datagrid-content">
                            {{ booking.special_requests ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill w-75" data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#rooms" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                            <IconWindow class="icon me-2    "/>
                            Rooms
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#charges" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                           tabindex="-1">
                            <IconCreditCard class="icon me-2"/>
                            Charges
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#statuses" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                           tabindex="-1">
                            <IconSquareCheck class="icon me-2"/>
                            Statuses
                        </a>
                    </li>
                    <li class="nav-item" role="presentation" v-if="booking.kids.length">
                        <a href="#children" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                           tabindex="-1">
                            <IconBabyCarriage class="icon me-2"/>
                            Children
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content py-4 px-2">
                    <div id="rooms" class="tab-pane active show" role="tabpanel">
                        <table class="table table-vcenter card-table table-striped">
                            <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Floor</th>
                                <th>Type</th>
                                <th>Smoking Preference</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="room in booking.rooms">
                                <td>{{ room.room_number }}</td>
                                <td>{{ room.floor_number }}</td>
                                <td>
                                    <Link :href="route('admin.roomTypes.edit', room.type.id)">
                                        {{ room.type.name }}
                                    </Link>
                                </td>
                                <td>
                                    <span class="badge" :class="displaySmoking(room.smoking_preference).bgClass">
                                        {{ displaySmoking(room.smoking_preference).label }}
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="charges" class="tab-pane" role="tabpanel">
                        <table class="table table-vcenter card-table table-striped w-75">
                            <thead>
                            <tr>
                                <th>Charge Type</th>
                                <th>Amount</th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="charge in booking.charges">
                                <td>{{ charge.charge_type }}</td>
                                <td>{{ number_format(charge.amount) }}</td>
                                <td>{{ charge.created_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="statuses" class="tab-pane" role="tabpanel">
                        <table class="table table-vcenter card-table table-striped w-75">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Created_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="status in booking.statuses">
                                <td>
                                    <span class="badge" :class="displayStatus(status.status).bgClass">
                                        {{ displayStatus(status.status).label }}
                                    </span>
                                </td>
                                <td>{{ status.description ?? '-' }}</td>
                                <td>{{ status.created_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="children" class="tab-pane" role="tabpanel" v-if="booking.kids.length">
                        <table class="table table-vcenter card-table table-striped w-50">
                            <thead>
                            <tr>
                                <th>Age</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="kid in booking.kids">
                                    <td>{{ kid.age }} years old</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps} from "vue"
import {IconArrowLeft, IconWindow, IconCreditCard, IconSquareCheck, IconBabyCarriage} from "@tabler/icons-vue";
import {useEnum} from "../../../Composables/useEnum.js";
import {Link} from "@inertiajs/vue3";
import {number_format} from "../../../Utils/helper.js";


const props = defineProps({
    booking: Object,
    statuses: Array,
    paymentStatuses: Array,
    smokingPreferences: Array,
})

const {display: displayStatus} = useEnum(props.statuses)
const {display: displayPaymentStatus} = useEnum(props.paymentStatuses)

const {
    display: displaySmoking
} = useEnum(props.smokingPreferences)

</script>
