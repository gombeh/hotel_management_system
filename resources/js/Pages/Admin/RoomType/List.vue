<template>
    <Head title="room types"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">Room Types</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <Link :href="route('admin.roomTypes.create')"
                      class="btn btn-primary btn-5 d-none d-sm-inline-block"
                      v-if="can.createRoomType">
                    <IconPlus class="icon icon-2"/>
                    Create new
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
                        <h3 class="card-title mb-0">Room Types</h3>
                        <p class="text-secondary m-0">List Room Types.</p>
                    </div>
                    <div class="col-md-auto col-sm-12 d-flex gap-2">
                        <div class="input-group input-group-flat w-auto">
                              <span class="input-group-text">
                                  <IconSearch class="icon icon-1"/>
                              </span>
                            <input id="advanced-table-search" type="text"
                                   class="form-control" autocomplete="off" v-model="filters.name">
                        </div>
                        <div class="w-auto">
                            <select-box
                                class="h-full"
                                placeholder="All Status"
                                v-model="filters.status"
                                :options="statuses"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <sort-head name="name" label="Name" v-model="sorts"/>
                        <sort-head name="size" label="Size" v-model="sorts"/>
                        <sort-head name="max_total_guests" label="Max Guests" v-model="sorts"/>
                        <th>
                            Available Rooms
                        </th>
                        <sort-head name="price" label="Price" v-model="sorts"/>
                        <sort-head name="status" label="Status" v-model="sorts"/>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    <tr v-for="roomType in roomTypes.data" :key="roomType.id">
                        <td>
                            <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                   aria-label="Select invoice" value="true">
                        </td>
                        <td>{{ roomType.name }}</td>
                        <td>{{ roomType.size }} m&sup2</td>
                        <td>{{ roomType.max_total_guests }}</td>
                        <td>{{ roomType.rooms_count }}</td>
                        <td>${{ roomType.price.toLocaleString('en-US') }}</td>
                        <td>
                            <span class="badge"
                                  :class="displayStatus(roomType.status).bgClass">
                                {{ displayStatus(roomType.status).label }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown" v-if="Object.values(roomType.can).some((per) => per === true) || can.viewRooms">
                                <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                    Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <Link :href="route('admin.rooms.index', {'filters[room_type_id]': roomType.id})"
                                          class="dropdown-item align-middle"
                                          v-if="can.viewRooms">
                                        <IconDoor class="icon icon1"/>
                                        Rooms
                                    </Link>
                                    <Link :href="route('admin.roomTypes.edit', roomType.id)"
                                          class="dropdown-item align-middle"
                                          v-if="roomType.can.edit">
                                        <IconEdit class="icon icon1"/>
                                        Edit
                                    </Link>
                                    <button class="dropdown-item" v-if="roomType.can.delete"
                                            @click="() => confirmDelete(route('admin.roomTypes.destroy', roomType.id))">
                                        <IconTrash class="icon icon1"/>
                                        Delete
                                    </button>
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
                <Pagination :links="roomTypes.meta.links"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, toRaw, watch} from "vue";
import {debounce} from "@tabler/core/dist/libs/list.js/src/utils/events.js";
import {router} from "@inertiajs/vue3";
import Pagination from "../../../Shared/Admin/Pagination.vue";
import {IconEdit, IconTrash, IconPlus, IconSearch, IconDoor} from '@tabler/icons-vue';
import {useConfirm} from "../../../Composables/useConfirm.js";
import SortHead from "../../../Components/SortHead.vue";
import SelectBox from "../../../Components/SelectBox.vue";
import {useEnum} from "../../../Composables/useEnum.js";

const props = defineProps({
    'roomTypes': Object,
    'filters': Object,
    'sorts': String,
    'limit': Number,
    'can': Object,
    'statuses': Array,
});
const confirmDelete = useConfirm();
const {
    select: statuses,
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
    router.get(route('admin.roomTypes.index'), {
        sorts: sorts.value,
        limit: limit.value,
        filters: toRaw(filters.value)
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
