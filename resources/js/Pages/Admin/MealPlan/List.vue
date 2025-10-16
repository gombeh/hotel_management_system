<template>
    <Head title="meal plans" />
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">Meal Plans</h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">

                <button v-if="access.createMealPlan" class="btn btn-primary btn-5 d-none d-sm-inline-block"
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
                        <h3 class="card-title mb-0">Meal Plans</h3>
                        <p class="text-secondary m-0">List Meal Plans.</p>
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
                            code
                        </th>
                        <th>
                            price
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                        <tr v-for="mealPlan in mealPlans" :key="mealPlan.id">
                            <td>
                                <input class="form-check-input m-0 align-middle table-selectable-check" type="checkbox"
                                       aria-label="Select invoice" value="true">
                            </td>
                            <td>{{ mealPlan.name }}</td>
                            <td>{{ mealPlan.code }}</td>
                            <td>${{ mealPlan.extra_price }}</td>
                            <td class="text-end">
                                <div class="dropdown" v-if="Object.values(mealPlan.access).some(per => per)">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown" aria-expanded="true">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                        <button class="dropdown-item align-middle"
                                                @click="openEditModal(mealPlan)"
                                                v-if="mealPlan.access.edit">
                                            <IconEdit class="icon icon1"/>
                                            Edit
                                        </button>
                                        <button class="dropdown-item"
                                                @click="() => confirmDelete(route('admin.mealPlans.destroy', mealPlan.id))"
                                                v-if="mealPlan.access.delete">
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
    <Create v-if="openModal && !editingMealPlan"/>
    <Update v-if="openModal && editingMealPlan" :mealPlan="editingMealPlan"/>
</template>

<script setup>
import {provide, ref} from "vue";
import Create from "./Create.vue";
import {IconEdit, IconTrash, IconPlus} from '@tabler/icons-vue';
import Update from "./Update.vue";
import {useConfirm} from "../../../Composables/useConfirm.js";

const confirmDelete = useConfirm();

defineProps({
    mealPlans: Object,
    access: Object,
});

let editingMealPlan = ref(null);
let openModal = ref(false);

provide("closeModal", () => {
    openModal.value = false
    if(editingMealPlan) editingMealPlan.value = null
});

const openEditModal = (mealPlan) => {
    editingMealPlan.value = mealPlan;
    openModal.value = true
}

</script>
