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
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <sort-head name="ref_number" v-model="sorts" label="Ref Number"/>
                        <sort-head name="customer.full_name" v-model="sorts" label="Customer"/>
                        <SortHead name="adults" v-model="sorts" label="Adults"/>
                        <SortHead name="children" v-model="sorts" label="Children"/>
                        <SortHead name="check_in" v-model="sorts" label="Check IN"/>
                        <SortHead name="check_out" v-model="sorts" label="Check OUT"/>
                        <SortHead name="rooms" v-model="sorts" label="Rooms"/>
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
                        <td>{{ booking.adults }}</td>
                        <td>{{ booking.children }}</td>
                        <td>{{ booking.check_in }}</td>
                        <td>{{ booking.check_out }}</td>
                        <td>{{ booking.rooms.map(r => r.room_number).join(', ')}}</td>
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
                                    <Link :href="route('admin.bookings.show', booking.id)" class="dropdown-item" v-if="booking.access.show">
                                        <IconEye class="icon icon1"/>
                                        Show
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
import {IconPlus, IconEye} from '@tabler/icons-vue';
import {useConfirm} from "../../../Composables/useConfirm.js";
import SortHead from "../../../Components/SortHead.vue";
import {useEnum} from "../../../Composables/useEnum.js";

const props = defineProps({
    'bookings': Object,
    'smokingPreferences': Array,
    'statuses': Array,
    'filters': Object,
    'sorts': String,
    'limit': Number,
    'access': Object,
});

const confirmDelete = useConfirm();
const {
    display: displayStatus
} = useEnum(props.statuses)


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
