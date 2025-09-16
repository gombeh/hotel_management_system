<template>
    <div class="row g-2 align-items-center mb-6">
        <div class="col">
            <h2 class="page-title">Users</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        @click="openCreateModal = !openCreateModal">
                    <IconPlus class="icon icon-2"/>
                    Create new user
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
                                       class="form-control" autocomplete="off" v-model="search">
                                <span class="input-group-text">
                                <kbd>ctrl + K</kbd>
                              </span>
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
                        <th>
                            <button class="table-sort d-flex justify-content-between"
                                    @click="sortColumn('full_name')"
                                    :class="{
                                            'asc': sorts?.full_name === 'asc',
                                            'desc': sorts?.full_name === 'desc'
                                        }">
                                Full Name
                            </button>
                        </th>
                        <th>
                            Roles
                        </th>
                        <th>
                            <button class="table-sort d-flex justify-content-between"
                                    @click="sortColumn('email')"
                                    :class="{
                                            'asc': sorts?.email === 'asc',
                                            'desc': sorts?.email === 'desc'
                                        }">
                                Email
                            </button>
                        </th>
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
                        <td class="sort-gender">admin</td>
                        <td class=sort-email>{{ user.email }}</td>
                        <td class="text-end">
                                <div class="dropdown">
                                  <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                          data-bs-toggle="dropdown" aria-expanded="true">
                                      Actions
                                  </button>
                                  <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <button class="dropdown-item align-middle" href="#"> <IconEdit class="icon icon1" /> Edit </button>
                                    <a class="dropdown-item" href="#"> <IconTrash class="icon icon1" /> Delete </a>
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
    <Create v-if="openCreateModal"/>
</template>

<script setup>
import {provide, ref, toRaw, watch} from "vue";
import {debounce} from "@tabler/core/dist/libs/list.js/src/utils/events.js";
import {router} from "@inertiajs/vue3";
import Pagination from "../../../Shared/Admin/Pagination.vue";
import Create from "./Create.vue";
import { IconEdit, IconTrash, IconPlus, IconSearch } from '@tabler/icons-vue';

const props = defineProps({
    'users': Object,
    'filters': Object,
    'sorts': Object,
    'limit': Number,
});

let openCreateModal = ref(false);
const search = ref(props.filters.search);
const sorts = ref(props.sorts ?? {});
const limit = ref(props.limit ?? 15)

provide("closeModal", function () {
    openCreateModal.value = false
});

const sortColumn = (field) => {
    const value = sorts.value;

    switch (value[field]) {
        case undefined:
        case null:
            value[field] = 'asc'
            break;
        case 'asc':
            value[field] = 'desc'
            break
        default:
            delete (value[field])
    }

    syncFilters();
}

watch(search, debounce(() => {
    syncFilters()
}, 300))

const syncFilters = () => {
    router.get(route('admin.users.index'), {
        sorts: toRaw(sorts.value),
        limit: limit.value,
        search: search.value
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
