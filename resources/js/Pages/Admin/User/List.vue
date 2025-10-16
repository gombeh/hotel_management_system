<template>
    <Head title="users" />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">Users</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        v-if="access.createUser"
                        @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    New Record
                </button>
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
                        <h3 class="card-title mb-0">Users</h3>
                        <p class="text-secondary m-0">List Users.</p>
                    </div>
                    <div class="col-md-auto col-sm-12">
                        <div class="ms-auto d-flex flex-wrap btn-list">
                            <div class="input-group input-group-flat w-auto">
                              <span class="input-group-text">
                                  <IconSearch class="icon icon-1"/>
                              </span>
                                <input id="advanced-table-search" type="text"
                                       class="form-control" autocomplete="off" v-model="filters.search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <sort-head
                            v-model="sorts"
                            name="full-name"
                            label="Full Name"
                        />
                        <th>
                            Roles
                        </th>
                        <sort-head
                            v-model="sorts"
                            name="email"
                            label="Email"
                        />
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    <tr v-for="user in users.data" :key="user.id">
                        <td>
                            <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                   aria-label="Select invoice" value="true">
                        </td>
                        <td class="sort-full_name">{{ user.full_name }}</td>
                        <td class="sort-gender">{{ user.roles.map(role => role.name).join(', ') }}</td>
                        <td class=sort-email>{{ user.email }}</td>
                        <td class="text-end">
                            <div class="dropdown" v-if="Object.values(user.access).some(per => per)">
                                <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                    Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <button class="dropdown-item align-middle" @click="openEditModal(user)" v-if="user.access.edit">
                                        <IconEdit class="icon icon1"/>
                                        Edit
                                    </button>
                                    <button class="dropdown-item" v-if="user.access.delete"
                                            @click="() => confirmDelete(route('admin.users.destroy', user.id))">
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
                <Pagination :links="users.meta.links"/>
            </div>
        </div>
    </div>
    <Create v-if="openModal && !editingUser"
            :sexes="sexes"
            :roles="roles"/>
    <Update v-if="openModal && editingUser"
            :sexes="sexes"
            :user="editingUser" :roles="roles"/>
</template>

<script setup>
import {provide, ref, toRaw, watch} from "vue";
import {debounce} from "@tabler/core/dist/libs/list.js/src/utils/events.js";
import {router} from "@inertiajs/vue3";
import Pagination from "../../../Shared/Admin/Pagination.vue";
import Create from "./Create.vue";
import {IconEdit, IconTrash, IconPlus, IconSearch} from '@tabler/icons-vue';
import Update from "./Update.vue";
import {useConfirm} from "../../../Composables/useConfirm.js";
import SortHead from "../../../Components/SortHead.vue";
import {useEnum} from "../../../Composables/useEnum.js";

const confirmDelete = useConfirm();

const props = defineProps({
    'users': Object,
    'filters': Object,
    'sorts': String,
    'limit': Number,
    'access': Object,
    'roles': Object,
    'sexes': Array,
});

const {select: sexes} = useEnum(props.sexes);

let editingUser = ref(null);
let openModal = ref(false);
const filters = ref(props.filters);
const sorts = ref(props.sorts);
const limit = ref(props.limit)

provide("closeModal", () => {
    openModal.value = false
    if(editingUser) editingUser.value = null
});

const openEditModal = (user) => {
    editingUser.value = user;
    openModal.value = true
}

watch(filters, debounce(() => {
    syncFilters()
}, 300), {
    deep: true
})

watch(sorts, () => syncFilters());

const syncFilters = () => {
    router.get(route('admin.users.index'), {
        sorts: sorts.value,
        limit: limit.value,
        filters: toRaw(filters.value)
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
