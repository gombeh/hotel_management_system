<template>
    <div class="row g-2 align-items-center mb-6">
        <div class="col">
            <h2 class="page-title">Roles</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    Create new role
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
                        <h3 class="card-title mb-0">Roles</h3>
                        <p class="text-secondary m-0">List Roles.</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"></th>
                        <th>
                            name
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr v-for="role in roles.data" :key="role.id">
                            <td>
                                <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                       aria-label="Select invoice" value="true">
                            </td>
                            <td>{{ role.name }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                        <button class="dropdown-item align-middle" @click="openEditModal(role)">
                                            <IconEdit class="icon icon1"/>
                                            Edit
                                        </button>
                                        <button class="dropdown-item"
                                                @click="() => confirmDelete(route('admin.roles.destroy', role.id))">
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
        </div>
    </div>
    <Create v-if="openModal"/>
    <Update v-if="openModal && editingRole" :role="editingRole"/>
</template>

<script setup>
import {provide, ref, toRaw, watch} from "vue";
import Create from "./Create.vue";
import {IconEdit, IconTrash, IconPlus} from '@tabler/icons-vue';
import Update from "./Update.vue";
import {useConfirm} from "../../../Composables/useConfirm.js";

const confirmDelete = useConfirm();

defineProps({
    'roles': Object,
});

let editingRole = ref(null);
let openModal = ref(false);

provide("closeModal", () => {
    openModal.value = false
    if(editingRole) editingRole.value = null
});

const openEditModal = (role) => {
    editingRole.value = role;
    openModal.value = true
}

</script>
