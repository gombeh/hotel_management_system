<template>
    <Head title="Create Booking"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">Create Booking</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.bookings.index')">
                <IconArrowLeft class="icon"/>
                Back
            </Link>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">Create Booking</div>
            <div class="card-body">
                <form id="createRoomTypes" method="post" @submit.prevent="handleCreateRoomType"
                      class="gap-inputs">
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="number"
                                min="1"
                                label="Adult"
                                v-model="form.adults"
                                :error="form.errors.adult"
                                placeholder="2"
                                required
                            />
                        </div>
                        <div class="col-6">
                            <base-input
                                type="number"
                                label="Children"
                                min="0"
                                max="10"
                                v-model="form.children"
                                :error="form.errors.children"
                                placeholder="0"
                            />
                        </div>
                    </div>
                    <div class="row col-8" v-if="form.children_age.length">
                        <Repeater
                            label="Children Ages"
                            v-model="form.children_age"
                            :errors="form.errors"
                            name="children_age"
                            :with-actions="false"
                            :heads="['Age']">
                            <template #default="{ item, index }" :key="index">
                                <td>
                                    <select-box
                                        placeholder="Choose Your Child Age"
                                        :options="ages"
                                        v-model="item.age"
                                        :error="item.errors?.age"
                                        required>
                                    </select-box>
                                </td>
                            </template>
                        </Repeater>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <base-input
                                type="date"
                                label="Check In"
                                :min="currentDate()"
                                v-model="form.check_in"
                                :error="form.errors.check_in"
                                required
                            />
                        </div>
                        <div class="col-6">
                            <base-input
                                type="date"
                                label="Check Out"
                                :min="addDays(Date.now(), 1)"
                                v-model="form.check_out"
                                :error="form.errors.check_out"
                                :onchange="changeCheckOut"
                                required
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <select-box
                                label="Smoking Preference"
                                v-model="form.smoking_preference"
                                :options="smoking"
                                required
                                :error="form.errors.smoking_preference"/>
                        </div>
                    </div>
                    <div class="row">
                        <Repeater
                            label="Rooms"
                            v-model="form.rooms"
                            :errors="form.errors"
                            name="rooms"
                            :heads="['Room Type', 'Quantity']"
                            :with-actions="!!roomTypes"
                            :default-row="{type_id: '', quantity: 1}">
                            <template #default="{ item, index }" :key="index" v-if="roomTypes">
                                <td>
                                    <select-box
                                        placeholder="Choose Your Room Type"
                                        :options="roomTypes"
                                        v-model="item.type_id"
                                        :error="item.errors?.type_id">
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
                            <select-box
                                label="Customer"
                                placeholder="Choose Your Customer"
                                :options="customers"
                                v-model="form.customer_id"
                                :error="form.errors.customer_id"
                                required>
                            </select-box>
                        </div>
                        <div class="col-6">
                            <select-box
                                label="Meal Plan"
                                placeholder="Choose Your Meal Plan"
                                :options="mealPlans"
                                v-model="form.meal_plan_id"
                                :error="form.errors.meal_plan_id"
                                required>
                            </select-box>
                        </div>
                    </div>
                    <div class="row">
                        <base-textarea
                            label="Special Requests"
                            placeholder="add extra pillow"
                            v-model="form.special_requests"
                            :error="form.errors.special_requests">
                        </base-textarea>
                    </div>
                    <div class="row">
                        <base-switch
                            label="Check In Now"
                            v-model="form.check_in_now"/>
                    </div>
                </form>
                <div class="card mt-4 bg-primary-lt" v-if="prices">
                    <div class="card-body">
                        <div class="card-title">
                            Prices for {{ prices.nights }} Night / {{ prices.nights + 1 }} Day
                        </div>
                        <div class="row mt-4">
                            <div class="col d-flex flex-column gap-4">
                                <div>Total Rooms Price: <span class="text-green bold">${{ prices.totalRooms }}</span>
                                </div>
                                <div :title="`$${roomType.price} / per night`" v-for="roomType in prices.roomTypes">
                                    {{ roomType.name }} Room Price (x{{ roomType.rooms }}):
                                    <span class="text-green bold">${{ roomType.totalPrice }}</span>
                                </div>
                            </div>
                            <div class="col d-flex flex-column gap-4">
                                <div>Total Meal plan Price: <span class="text-green bold">${{ prices.mealPlan }}</span>
                                </div>
                                <div v-for="mealPlan in prices.mealPlanAges" :title="`$${mealPlan.price} / per night`">
                                    {{ capitalize(mealPlan.name) }} Meal plan Price (x{{ mealPlan.count }}):
                                    <span class="text-green bold">${{ mealPlan.totalPrice }}</span>
                                </div>
                            </div>
                            <div class="col d-flex flex-column gap-4">
                                <div>Tax: <span class="text-green bold">${{ prices.tax }}</span></div>
                                <div>Total Price: <span class="text-green bold">${{ prices.total }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
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
import {defineProps, ref, watch} from "vue"
import {IconDeviceFloppy, IconArrowLeft} from "@tabler/icons-vue";
import BaseInput from "../../../Components/BaseInput.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import SelectBox from "../../../Components/SelectBox.vue";
import {useEnum} from "../../../Composables/useEnum.js";
import Repeater from "../../../Components/Repeater.vue";
import BaseTextarea from "../../../Components/BaseTextarea.vue";
import BaseSwitch from "../../../Components/BaseSwitch.vue";
import {addDays, capitalize, currentDate, diffDays} from "../../../Utils/helper.js";

const page = usePage();

const props = defineProps({
    customers: Object,
    mealPlans: Object,
    smokingPreferences: Array,
});

const roomTypes = ref(null);
const prices = ref(null);

const {
    select: smoking,
    default: defaultSmoking,
} = useEnum(props.smokingPreferences)

const form = useForm({
    customer_id: '',
    adults: '',
    children: 0,
    check_in: '',
    check_out: '',
    smoking_preference: defaultSmoking,
    rooms: [{
        type_id: '',
        quantity: 1,
    }],
    children_age: [],
    meal_plan_id: '',
    special_requests: '',
    check_in_now: false,
});

const ages = Object.fromEntries(
    Array.from({length: 13}, (_, i) => [i, `${i} years old`])
);

function changeCheckOut () {
    form.errors.check_out = '';
    if(!form.check_in) {
        form.check_out = '';
         form.errors.check_out= 'You first must select CHECK IN'
    }

    const diffDay = diffDays(form.check_in, form.check_out, false);

    if(diffDay < 1) {
        form.check_out = '';
        form.errors.check_out= 'Diff days between checkout and checkin must be equal or greater than ONE';
    }
}

watch(
    () => [form.adults, form.children, form.check_in, form.check_out, form.smoking_preference],
    (form) => {
        if (form.some(val => val === "")) {
            if (roomTypes.value) roomTypes.value = null;
            return;
        }

        const [adults, children, check_in, check_out, smoking_preference] = form;

        axios.post(route('admin.booking.roomTypes'), {adults, children, check_in, check_out, smoking_preference})
            .then(res => {
                    roomTypes.value = res.data.roomTypes;
                }
            )
    })

watch(
    () => [form.adults, form.children, form.rooms, form.meal_plan_id, form.children_age, form.check_in, form.check_out],
    (form) => {
        if (form.some(val => val === "")) return null;

        const [adults, children, rooms, meal_plan_id, children_age, check_in, check_out] = form;
        const nights = diffDays(check_in, check_out);

        axios.post(route('admin.booking.prices'), {adults, children, rooms, meal_plan_id, children_age, nights})
            .then(res => {
                    prices.value = {...res.data, nights};
                }
            )
    }, {
        deep: true
    });

watch(() => form.children, (ch) => {

    let children = ch > 10 ? 10 : ch;

    if (!children) {
        form.children_age = [];
        return
    }

    const diff = children - form.children_age.length;

    if (diff > 0) {
        const ages = Array.from({length: diff}, () => ({age: ''}));
        form.children_age.push(...ages);
    } else {
        for (let i = 0; i < Math.abs(diff); i++) {
            form.children_age.pop();
        }
    }
})

const handleCreateRoomType = () => {
    form.post(route('admin.bookings.store'), {
        onSuccess: () => window.location.reload(),
    });
}

</script>
