<template>
    <Modal title="Edit Cancellation Rule" formId="editCancellationRuleForm">
        <form @submit.prevent="submitEdit" method="post" id="editCancellationRuleForm" class="gap-inputs">
            <div class="row">
                <BaseInput
                    type="number"
                    label="Min days before checkin"
                    v-model="form.min_days_before"
                    :error="form.errors.min_days_before"
                    placeholder="0"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    type="number"
                    label="Max days before checkin"
                    v-model="form.max_days_before"
                    :error="form.errors.max_days_before"
                    placeholder="1"
                    required
                />
            </div>
            <div class="row">
                <BaseInput
                    type="number"
                    label="Penalty percent"
                    v-model="form.penalty_percent"
                    :error="form.errors.penalty_percent"
                    placeholder="10"
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
        </form>
    </Modal>
</template>
<script setup lang="ts">
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";
import BaseTextarea from "../../../Components/BaseTextarea.vue";

const {cancellationRule} = defineProps({
    cancellationRule: Object
})

const form = useForm({
    min_days_before: cancellationRule.min_days_before,
    max_days_before: cancellationRule.max_days_before,
    penalty_percent: cancellationRule.penalty_percent,
    description: cancellationRule.description,
});

const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.cancellationRules.update', cancellationRule.id), {
        onSuccess: () => closeModal()
    })
}

</script>
