<template>
    <Head title="bed types" />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">Bed Types</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button v-if="can.create" class="btn btn-primary btn-5 d-none d-sm-inline-block"
                        @click="openModal = !openModal">
                    <IconPlus class="icon icon-2"/>
                    Create
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
                        <h3 class="card-title mb-0">Bed Types</h3>
                        <p class="text-secondary m-0">List Bed Types.</p>
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
                        <th>
                            capacity
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr v-for="bedType in bedTypes" :key="bedType.id">
                            <td>
                                <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                       aria-label="Select invoice" value="true">
                            </td>
                            <td>{{ bedType.name }}</td>
                            <td>{{ bedType.capacity }}</td>
                            <td class="text-end">
                                <div class="dropdown" v-if="Object.values(bedType.can).some((per) => per === true)">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                        <button class="dropdown-item align-middle"
                                                @click="openEditModal(bedType)"
                                                v-if="bedType.can.edit">
                                            <IconEdit class="icon icon1"/>
                                            Edit
                                        </button>
                                        <button class="dropdown-item"
                                                @click="() => confirmDelete(route('admin.bedTypes.destroy', bedType.id))"
                                                v-if="bedType.can.delete">
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
    <Create v-if="openModal && !editingBedType"/>
    <Update v-if="openModal && editingBedType" :bedType="editingBedType"/>
</template>

<script setup>
import {provide, ref} from "vue";
import Create from "./Create.vue";
import {IconEdit, IconTrash, IconPlus} from '@tabler/icons-vue';
import Update from "./Update.vue";
import {useConfirm} from "../../../Composables/useConfirm.js";

const confirmDelete = useConfirm();

defineProps({
    bedTypes: Object,
    can: Object,
});

let editingBedType = ref(null);
let openModal = ref(false);

provide("closeModal", () => {
    openModal.value = false
    if(editingBedType) editingBedType.value = null
});

const openEditModal = (bedType) => {
    editingBedType.value = bedType;
    openModal.value = true
}

</script>
