<template>
    <Modal title="Edit Meal Plan" formId="editMealPlanForm">
        <form @submit.prevent="submitEdit" method="post" id="editMealPlanForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    placeholder="name"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    label="Code"
                    v-model="form.code"
                    :error="form.errors.code"
                    placeholder="code"
                    required
                />
            </div>
            <div class="row">
                <BaseTextarea
                    label="Description"
                    v-model="form.description"
                    :error="form.errors.description"
                    placeholder="description"
                />
            </div>

            <div class="row">
                <BaseInput
                    label="Extra Price"
                    type="number"
                    v-model="form.extra_price"
                    :error="form.errors.extra_price"
                    placeholder="extra price"
                    required
                />
            </div>
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import BaseTextarea from "../../../Components/BaseTextarea.vue";

const {mealPlan} = defineProps({
    mealPlan: Object
})

const form = useForm({
    name: mealPlan.name,
    code: mealPlan.code,
    description: mealPlan.description,
    extra_price: mealPlan.extra_price,
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.mealPlans.update', mealPlan.id), {
        onSuccess: () => closeModal()
    })
}

</script>
