<template>
    <Head title="dashboard"/>
    <div class=" g-2 align-items-center">
        <div class="page-pretitle">Overview</div>
        <h2 class="page-title">Dashboard</h2>
    </div>

    <!-- Top Cards -->
    <div class="row g-3 mt-3">

        <!-- Today Check-ins -->
        <div class="col-md-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                        <span class="bg-success text-white avatar">
                           <IconDoorEnter class="icon"/>
                        </span>
                        </div>
                        <div class="col">
                            <h6 class="font-weight-medium mb-1">Today Check-ins</h6>
                            <h4 class="text-secondary mb-0">{{ today_checkins }}</h4>
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
                        <span class="bg-danger text-white avatar">
                           <IconDoorExit class="icon"/>
                        </span>
                        </div>
                        <div class="col">
                            <h6 class="font-weight-medium mb-1">Today Check-outs</h6>
                            <h4 class="text-secondary mb-0">{{ today_checkouts }}</h4>
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
                        <span class="bg-warning text-white avatar">
                           <IconCreditCard class="icon"/>
                        </span>
                        </div>
                        <div class="col">
                            <h6 class="font-weight-medium mb-1">Pending Payments</h6>
                            <h4 class="text-secondary mb-0">{{ pending_payments }}</h4>
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
                        <span class="bg-primary text-white avatar">
                           <IconUser class="icon"/>
                        </span>
                        </div>
                        <div class="col">
                            <h6 class="font-weight-medium mb-1">Active Guests</h6>
                            <h4 class="text-secondary mb-0">{{ active_guests }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Room Status -->
    <div class="row mt-4 g-3">
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm border-0 w-full">
                <div class="card-header border-0">
                    <h5 class="mb-0">Room Status</h5>
                </div>
                <div class="card-body">

                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="ti ti-bed text-success me-2"></i> Available</span>
                            <span class="badge bg-success-lt rounded-pill">{{ room_status['available'] }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="ti ti-door-enter text-warning me-2"></i> Occupied</span>
                            <span class="badge bg-warning-lt rounded-pill">{{ room_status['occupied'] }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="ti ti-ban text-danger me-2"></i> Out of Service</span>
                            <span class="badge bg-danger-lt rounded-pill">{{ room_status['out_of_service'] }}</span>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm border-0 w-full">
                <div class="card-header border-0">
                    <h5 class="mb-0">Revenue Summary</h5>
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between p-2 border-bottom">
                        <span><i class="ti ti-cash text-primary me-2"></i> Today</span>
                        <strong>{{ money_format(revenue['today']) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between p-2 border-bottom">
                        <span><i class="ti ti-calendar-time text-warning me-2"></i> This Week</span>
                        <strong>{{ money_format(revenue['week']) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <span><i class="ti ti-calendar-month text-success me-2"></i> This Month</span>
                        <strong>{{ money_format(revenue['month']) }}</strong>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Latest Bookings -->
    <div class="card mt-4">
        <div class="card-header border-0">
            <h5 class="mb-0">Latest Bookings</h5>
        </div>
        <div class="card-table table-responsive p-0">
            <table class="table table-vcenter">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th>Customer</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Paid Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="booking in latest_bookings">
                    <td>{{ booking.ref_number }}</td>
                    <td>{{ booking.customer.full_name }}</td>
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
                </tbody>
            </table>

        </div>
    </div>
</template>


<script setup>
import {money_format} from "../../Utils/helper.js";
import {useEnum} from "../../Composables/useEnum.js";
import {IconDoorEnter, IconDoorExit, IconCreditCard, IconUser} from '@tabler/icons-vue'

const {statuses} = defineProps(
    {
        'today_checkins': Number,
        'today_checkouts': Number,
        'pending_payments': Number,
        'active_guests': Number,
        'room_status': Number,
        'revenue': Number,
        'latest_bookings': Number,
        'statuses': Object
    }
)

const {display: displayStatus} = useEnum(statuses)
</script>
