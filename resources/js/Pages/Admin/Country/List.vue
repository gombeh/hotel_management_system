<template>
    <Head title="countries" />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">Countries</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        v-if="can.createCountry"
                        @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    Create new country
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
                        <h3 class="card-title mb-0">Countries</h3>
                        <p class="text-secondary m-0">List Countries.</p>
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
                                    @click="sortColumn('name')"
                                    :class="{
                                            'asc': sorts?.name === 'asc',
                                            'desc': sorts?.name === 'desc'
                                        }">
                                 Name
                            </button>
                        </th>
                        <th>
                            <button class="table-sort d-flex justify-content-between"
                                    @click="sortColumn('short')"
                                    :class="{
                                            'asc': sorts?.short === 'asc',
                                            'desc': sorts?.short === 'desc'
                                        }">
                                Short
                            </button>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    <tr v-for="country in countries.data" :key="country.id">
                        <td>
                            <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                   aria-label="Select invoice" value="true">
                        </td>
                        <td class="sort-full_name">{{ country.name }}</td>
                        <td class="sort-gender">{{ country.short }}</td>
                        <td class="text-end">
                            <div class="dropdown" v-if="Object.values(country.can).some((per) => per === true)">
                                <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                    Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                    <button class="dropdown-item align-middle"
                                            @click="openEditModal(country)"
                                            v-if="country.can.edit">
                                        <IconEdit class="icon icon1"/>
                                        Edit
                                    </button>
                                    <button class="dropdown-item" v-if="country.can.delete"
                                            @click="() => confirmDelete(route('admin.countries.destroy', country.id))">
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
                <Pagination :links="countries.meta.links"/>
            </div>
        </div>
    </div>
    <Create v-if="openModal"/>
    <Update v-if="openModal && editingCountry" :country="editingCountry"/>
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

const confirmDelete = useConfirm();

const props = defineProps({
    'countries': Object,
    'filters': Object,
    'sorts': Object,
    'limit': Number,
    'can': Object,
    'roles': Object
});

let editingCountry = ref(null);
let openModal = ref(false);
const search = ref(props.filters.search);
const sorts = ref(props.sorts ?? {});
const limit = ref(props.limit ?? 15)

provide("closeModal", () => {
    openModal.value = false
    if(editingCountry) editingCountry.value = null
});

const openEditModal = (country) => {
    editingCountry.value = country;
    openModal.value = true
}


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
    router.get(route('admin.countries.index'), {
        sorts: toRaw(sorts.value),
        limit: limit.value,
        search: search.value
    }, {
        preserveState: true,
        replace: true
    })
}

</script>
