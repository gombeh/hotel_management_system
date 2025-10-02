<template>
    <Head title="permissions"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">Update Room Type</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.roomTypes.index')">
                <IconArrowLeft class="icon"/>
                Back
            </Link>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">Update Room Type</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleCreateRoomType"
                      class="d-flex flex-column gap-4">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                label="Name"
                                v-model="form.name"
                                :error="form.errors.name"
                                placeholder="Your name"/>
                        </div>

                        <div class="col-6">
                            <base-input
                                label="Slug"
                                v-model="form.slug"
                                :error="form.errors.slug"
                                placeholder="Your slug"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                label="View"
                                v-model="form.view"
                                :error="form.errors.view"
                                placeholder="Your view"/>
                        </div>
                        <div class="col-6">
                            <base-input
                                label="Size"
                                type="number"
                                min="1"
                                v-model="form.size"
                                :error="form.errors.size"
                                placeholder="Your size"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <base-input
                                label="Max Adult"
                                type="number"
                                min="1"
                                v-model="form.max_adult"
                                :error="form.errors.max_adult"
                                placeholder="Your max adult"/>
                        </div>
                        <div class="col-4">
                            <base-input
                                label="Max Children"
                                type="number"
                                min="1"
                                v-model="form.max_children"
                                :error="form.errors.max_children"
                                placeholder="Your max children"/>
                        </div>
                        <div class="col-4">
                            <base-input
                                label="Max Total Guests"
                                type="number"
                                min="1"
                                v-model="form.max_total_guests"
                                :error="form.errors.max_total_guests"
                                placeholder="Your max adult"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                label="Price"
                                type="number"
                                min="1"
                                v-model="form.price"
                                :error="form.errors.price"
                                placeholder="Your price"/>
                        </div>
                        <div class="col-6">
                            <base-input
                                label="Extra Bed Price"
                                type="number"
                                min="1"
                                v-model="form.extra_bed_price"
                                :error="form.errors.extra_bed_price"
                                placeholder="Your extra bed price"/>
                        </div>
                    </div>
                    <div class="row">
                        <Repeater
                            label="Bed Types"
                            v-model="form.bedTypes"
                            :errors="form.errors"
                            name="bedTypes"
                            :heads="['Bed Type', 'Quantity']"
                            :default-row="{id: '', quantity: 1}">
                            <template #default="{ item, index }" :key="index">
                                <td>
                                    <select-box
                                        v-model="item.id"
                                        :error="item.errors?.id">
                                        <option v-for="bedType in bedTypes" :value="bedType.id" :key="bedType.id">
                                            {{ bedType.name }}
                                        </option>
                                    </select-box>
                                </td>
                                <td>
                                    <base-input
                                        type="number"
                                        min="1"
                                        v-model="item.quantity"
                                        :error="item.errors?.quantity"
                                        placeholder="Your quantity"/>
                                </td>
                            </template>
                        </Repeater>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <multi-select
                                v-model="form.facilities"
                                label="Facilities"
                                :options="facilities"
                                :error="form.errors.facilities || form.errors['facilities.0']"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <quill-editor
                            v-model="form.description"
                            :error="form.errors.description"
                            label="Description"/>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <filepond-uploader
                                label="Main Image"
                                v-model="form.mainImage"
                                :error="form.errors.mainImage"
                                :hasNeedReload="false"/>
                        </div>
                        <div class="col-6">
                            <filepond-uploader
                                label="Gallery"
                                v-model="form.gallery"
                                allow-multiple
                                allow-reorder
                                :max-files="128"
                                :error="form.errors.gallery"
                                :hasNeedReload="false"/>
                        </div>
                    </div>

                    <base-switch
                        label="Active"
                        v-model="form.status"
                        :rules="{'active': true, 'inactive': false}"/>
                </form>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary ms-auto" form="createRoomTypes">
                    <IconDeviceFloppy class="icon"/>
                    <span>Save</span>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps, watch} from "vue"
import {IconDeviceFloppy, IconArrowLeft} from "@tabler/icons-vue";
import BaseInput from "../../../Components/BaseInput.vue";
import {slugify} from "../../../Utils/helper.js";
import {useForm, usePage} from "@inertiajs/vue3";
import FilepondUploader from "../../../Components/FilepondUploader.vue";
import QuillEditor from "../../../Components/QuillEditor.vue";
import MultiSelect from "../../../Components/MultiSelect.vue";
import Repeater from "../../../Components/Repeater.vue";
import SelectBox from "../../../Components/SelectBox.vue";
import BaseSwitch from "../../../Components/BaseSwitch.vue";

const page = usePage();

const {roomType} = defineProps({
    roomType: Object,
    bedTypes: Object,
    facilities: Object,
})

const form = useForm({
    name: roomType.name,
    slug: roomType.slug,
    view: roomType.view,
    size: roomType.size,
    max_adult: roomType.max_adult,
    max_children: roomType.max_children,
    max_total_guests: roomType.max_total_guests,
    price: roomType.price,
    extra_bed_price: roomType.extra_bed_price,
    facilities: roomType.facilities.map(fac => fac.id),
    bedTypes: roomType.bedTypes.map(bedType => ({
        'id': bedType.id,
        'quantity': bedType.quantity
    })),
    description: roomType.description,
    mainImage: roomType.mainImage,
    gallery: roomType.gallery,
    status: roomType.status,
});


watch(
    () => form.name,
    (value) => {
        form.slug = slugify(value);
    });


const handleCreateRoomType = () => {
    form.put(route('admin.roomTypes.update', roomType.id));
}

</script>
