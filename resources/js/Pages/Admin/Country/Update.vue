<template>
    <Modal title="Edit Countries" formId="editCountryForm">
        <form @submit.prevent="submitEdit" method="post" id="editCountryForm">
            <div class="mb-3">
                <BaseInput
                    label="Name"
                    v-model="form.name"
                    :error="form.errors.name"
                    placeholder="your name"
                    required
                />
            </div>
            <div class="mb-3">
                <BaseInput
                    label="Short"
                    v-model="form.short"
                    :error="form.errors.short"
                    placeholder="your short"
                    required
                />
            </div>
        </form>
    </Modal>
</template>
<script setup >
import Modal from "../../../Components/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import BaseInput from "../../../Components/BaseInput.vue";
import {inject} from "vue";


const {country} = defineProps({
    country: Object,
})

const form = useForm({
    name: country.name,
    short: country.short,
});


const closeModal = inject('closeModal');
const submitEdit = () => {
    form.put(route('admin.countries.update', country.id), {
        onSuccess: () => closeModal()
    })
}

</script>
