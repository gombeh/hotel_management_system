<template>
    <Head title="bookings"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">Bookings</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <Link :href="route('admin.bookings.create')" class="btn btn-primary btn-5 d-none d-sm-inline-block"
                      v-if="access.createBookings"
                      @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    New Record
                </Link>
            </div>
            <!-- BEGIN MODAL -->
            <!-- END MODAL -->
        </div>
    </div>

    <div class="card">
        <div class="card-table">
            <div class="card-header d-block">
                <div class="row">
                    <h3 class="card-title mb-0">Bookings</h3>
                    <p class="text-secondary m-0">List Bookings.</p>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <select-box
                            placeholder="All Customers"
                            v-model="filters.customer_id"
                            :options="customers"/>
                    </div>
                    <div class="input-group input-group-flat w-auto col-2">
                        <input id="advanced-table-search" type="number"
                               placeholder="Ref Number"
                               class="form-control" autocomplete="off" v-model="filters.ref_number">
                    </div>
                    <div class="input-group input-group-flat w-auto col-2">
                        <input id="advanced-table-search" type="number"
                               placeholder="Room Number"
                               class="form-control" autocomplete="off" v-model="filters.room_number">
                    </div>
                    <div class="col-2">
                        <select-box
                            placeholder="All Status"
                            v-model="filters.status"
                            :options="selectStatuses"/>
                    </div>
                    <Link :href="route('admin.bookings.index')" class="btn btn-primary w-auto">
                        <IconRestore class="icon m-0"/>
                    </Link>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <sort-head name="ref_number" v-model="sorts" label="Ref Number"/>
                        <sort-head name="full_name" v-model="sorts" label="Customer"/>
                        <th>Guests</th>
                        <SortHead name="check_in" v-model="sorts" label="Check IN"/>
                        <SortHead name="check_out" v-model="sorts" label="Check OUT"/>
                        <th>Rooms</th>
                        <SortHead name="total_price" v-model="sorts" label="Total Price"/>
                        <SortHead name="deposit_amount" v-model="sorts" label="Paid Amount"/>
                        <SortHead name="status" v-model="sorts" label="status"/>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    <tr v-for="booking in bookings.data" :key="booking.id">
                        <td>
                            <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                   aria-label="Select invoice" value="true">
                        </td>
                        <td>{{ booking.ref_number }}</td>
                        <td>{{ booking.customer.full_name }}</td>
                        <td>{{ booking.adults }} - {{ booking.children }}</td>
                        <td>{{ booking.check_in }}</td>
                        <td>{{ booking.check_out }}</td>
                        <td>
                            <span :title="booking.rooms.map(r => r.room_number).join(', ')">
                                {{ booking.rooms.length }} {{ booking.rooms.length === 1 ? 'Room' : 'Rooms' }}
                            </span>
                        </td>
                        <td>${{ booking.total_price }}</td>
                        <td>${{ booking.deposit_amount }}</td>
                        <td>
                            <span class="badge" :class="displayStatus(booking.status).bgClass">
                                {{ displayStatus(booking.status).label }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown" v-if="Object.values(booking.access).some(per => per)">
                                <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                    Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <Link :href="route('admin.bookings.show', booking.id)" class="dropdown-item"
                                          v-if="booking.access.show">
                                        <IconEye class="icon icon1"/>
                                        Show
                                    </Link>
                                    <Link :href="route('admin.bookings.payments.index', booking.id)"
                                          class="dropdown-item" v-if="booking.access.payments">
                                        <IconCreditCard class="icon icon1"/>
                                        Payments
                                    </Link>
                                    <button @click="() => confirmCheck(route('admin.bookings.checkin', booking.id), 'Check-in', booking.customer.full_name)"
                                            class="dropdown-item"
                                            v-if="booking.access.checkIn">
                                        <IconDoorEnter class="icon icon1"/>
                                        Check In
                                    </button>
                                    <Link @click="() => confirmCheck(route('admin.bookings.checkout', booking.id), 'Check-out', booking.customer.full_name)"
                                          class="dropdown-item"
                                          v-if="booking.access.checkOut">
                                        <IconDoorExit class="icon icon1"/>
                                        Check Out
                                    </Link>
                                </div>
                            </div>
                        </td>
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
                <Pagination :links="bookings.meta.links"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, toRaw, watch} from "vue";
import {debounce} from "@tabler/core/dist/libs/list.js/src/utils/events.js";
import {router} from "@inertiajs/vue3";
import Pagination from "../../../Shared/Admin/Pagination.vue";
import {IconPlus, IconEye, IconCreditCard, IconDoorEnter, IconDoorExit, IconRestore} from '@tabler/icons-vue';
import SortHead from "../../../Components/SortHead.vue";
import {useEnum} from "../../../Composables/useEnum.js";
import Swal from "sweetalert2";
import SelectBox from "../../../Components/SelectBox.vue";

const props = defineProps({
    'bookings': Object,
    'smokingPreferences': Array,
    'customers': Object,
    'statuses': Array,
    'filters': Object,
    'sorts': String,
    'limit': Number,
    'access': Object,
});

const {
    select: selectStatuses,
    display: displayStatus
} = useEnum(props.statuses)


const confirmCheck = (url, action, customer) => {
    Swal.fire({
        title:  'Confirm ' + action,
        html: `<div style="text-align: left">Are you sure you want to ${action} the booking for customer <b>${customer}</b>?</br>
This action is final and will be officially recorded in the system.</div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: `Yes, ${action} now`,
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(url)
        }
    })
}

const filters = ref(props.filters);
const sorts = ref(props.sorts);
const limit = ref(props.limit)

watch(filters, debounce(() => {
    syncFilters()
}, 300), {
    deep: true
})


watch(sorts, () => syncFilters());

const syncFilters = () => {
    router.get(route('admin.bookings.index'), {
        sorts: sorts.value,
        limit: limit.value,
        filters: toRaw(filters.value)
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
