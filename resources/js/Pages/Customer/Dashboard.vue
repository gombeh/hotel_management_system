<template>
    <div class="container">
        <Head title="dashboard" />
        <div class="g-2 align-items-center mt-4">
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title pt-1">Dashboard</h2>
        </div>

        <div class="row g-3 mt-3">

            <!-- Today Check-ins -->
            <div class="col-md-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                        <span class="bg-success text-white avatar  ml-0 rounded" style="padding: 12px">
                           <IconCalendar class="icon"/>
                        </span>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-medium mb-1">Upcoming Stays</h6>
                                <h4 class="text-secondary mb-0">{{ upcoming_count }} booking(s)</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today Check-outs -->
            <div class="col-md-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                        <span class="bg-danger text-white avatar  ml-0 rounded" style="padding: 12px">
                           <IconDoorExit class="icon"/>
                        </span>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-medium mb-1">Past Bookings</h6>
                                <h4 class="text-secondary mb-0">{{ past_count }} completed</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="col-md-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                        <span class="bg-warning text-white avatar  ml-0 rounded" style="padding: 12px">
                           <IconHistory class="icon"/>
                        </span>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-medium mb-1">Total Payments</h6>
                                <h4 class="text-secondary mb-0">{{ money_format(total_paid) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Guests -->
            <div class="col-md-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                        <span class="bg-primary text-white avatar  ml-0 rounded" style="padding: 12px">
                           <IconBan class="icon"/>
                        </span>
                            </div>
                            <div class="col">
                                <h6 class="font-weight-medium mb-1">Cancellations</h6>
                                <h4 class="text-secondary mb-0">{{ cancellation_count }} cancelled</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Upcoming Booking Box -->
        <div class="card mb-4 shadow-sm mt-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><IconCalendarEvent class="icon" /> Your Upcoming Booking</h5>
            </div>

            <div class="card-body">
                <!-- If no upcoming booking -->
                <p class="text-muted" v-if="!upcoming_booking">
                    You have no upcoming bookings.
                </p>

                <!-- If upcoming booking exists -->
                <div class="room-details" v-else>
                    <h5>Room: {{ upcoming_booking.rooms[0].type.name }}</h5>
                    <p class="mb-2 mt-3">
                        <IconCalendarStats class="icon" />
                        {{ upcoming_booking.check_in }} → {{ upcoming_booking.check_out }}
                    </p>
                    <p class="mb-2">
                        <IconCurrencyDollar class="icon" />
                        Total Price: <strong>{{ money_format(upcoming_booking.total_price) }}</strong>
                    </p>

                    <a :href="route('bookings.success', upcoming_booking.id)"
                       class="btn btn-book-now px-3 py-2 fs-6">
                        <IconEye class="icon me-1" /> View Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Latest Bookings -->
        <div class="card mt-4">
            <div class="card-header border-0">
                <h5 class="mb-0">Recent Bookings</h5>
            </div>
            <div class="card-table table-responsive p-0">
                <table class="table table-vcenter">
                    <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Guests</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Paid Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="booking in recent_bookings" v-if="recent_bookings.length">
                        <td><Link :href="route('bookings.success', booking.id)"> {{ booking.ref_number }}</Link></td>
                        <th>{{booking.adults + booking.children}}</th>
                        <td>{{ booking.check_in }}</td>
                        <td>{{ booking.check_out }}</td>
                        <td>
                        <span class="badge" :class="displayStatus(booking.status).bgClass">
                                {{ displayStatus(booking.status).label }}
                        </span>
                        </td>
                        <td>{{ money_format(booking.total_price) }}</td>
                        <td>{{ money_format(booking.deposit_amount) }}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="7" class="text-center py-3 text-muted">
                            No bookings found.
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>


<script setup>
import {IconCalendar, IconBan, IconDoorExit, IconHistory, IconCalendarEvent, IconCalendarStats, IconCurrencyDollar, IconEye} from "@tabler/icons-vue";
import {money_format} from "../../Utils/helper.js";
import {useEnum} from "../../Composables/useEnum.js";

const {statuses} = defineProps({
    upcoming_count: Number,
    past_count: Number,
    total_paid: Number,
    cancellation_count: Number,
    upcoming_booking: Number,
    recent_bookings: Number,
    'statuses': Object
})

const {display: displayStatus} = useEnum(statuses)

</script>

<style scoped>
.icon {
    vertical-align: middle !important;
}
</style>
