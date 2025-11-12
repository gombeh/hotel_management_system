<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Booking</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li>
                        <Link :href="route('home')">Home</Link>
                    </li>
                    <li class="current">Booking</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Booking Section -->
    <section id="booking" class="booking section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="reservation-wrapper">

                <div class="reservation-header text-center" data-aos="fade-up" data-aos-delay="200">
                    <h2>Reserve Your Stay</h2>
                    <p class="lead">Experience unmatched hospitality with our streamlined booking process</p>
                </div>

                <div class="booking-grid d-flex gap-5">
                    <div class="hotel-showcase col-4" data-aos="fade-left" data-aos-delay="400">
                        <div class="card hotel-highlights p-0">
                            <div class="showcase-image rounded-bottom-0 mb-1">
                                <img :src="roomType.mainImage[0].url" alt="Hotel luxury showcase" class="img-fluid">
                            </div>
                            <div class="card-body room-details">
                                <Link :href="route('roomTypes.show', {roomType: roomType.slug, filters})"><h3
                                    class="text-lg-start">{{ roomType.name }}l</h3></Link>
                                <div class="room-capacity mb-4">
                                    <div class="capacity-item">
                                        <i class="bi bi-people"></i>
                                        <span>Up to {{ roomType.max_total_guests }} guests</span>
                                    </div>
                                    <div class="capacity-item">
                                        <i class="bi bi-grid"></i>
                                        <span>{{ roomType.size }} m²</span>
                                    </div>
                                    <div class="capacity-item">
                                        <i class="bi bi-bed"></i>
                                        <span v-text="roomType.bedTypes.map(rt => rt.name).join(' + ')"></span>
                                    </div>
                                </div>
                                <div class="room-rating mb-3">
                                    <span class="rating-score">4.8</span>
                                    <div class="stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <span class="reviews-count">(127 reviews)</span>
                                </div>
                            </div>
                        </div>

                        <div class="hotel-highlights" v-if="form.adults && form.children !== '' && form.rooms && form.check_in && form.check_out">
                            <h3 class="text-lg-start m-0">Your booking details</h3>
                            <div class="d-flex gap-4 mt-4 pb-3" style="border-bottom: 1px solid color-mix(in srgb, var(--default-color), transparent 90%);">
                                <div class="d-flex flex-column gap-2" style="margin-right: 5px">
                                    <span>Check-in</span>
                                    <span class="bold text-black" style="font-weight: 700">{{moment(form.check_in).format('ddd, MMM D, Y')}}</span>
                                    <span class="text-secondary" style="font-size: 14px">4:00 PM – 11:00 PM</span>
                                </div>
                                <div class="d-flex flex-column gap-2" style="border-left: 1px solid color-mix(in srgb, var(--default-color), transparent 90%); padding-left: 2rem">
                                    <span>Check-out</span>
                                    <span class="bold text-black" style="font-weight: 700">{{moment(form.check_out).format('ddd, MMM D, Y')}}</span>
                                    <span class="text-secondary" style="font-size: 14px">4:00 PM – 11:00 PM</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="mb-1">You selected</div>
                                <div class="bold text-black" style="font-weight: 700">
                                    {{diffDays(form.check_out, form.check_in)}} nights, {{ form.rooms }} room for {{form.adults}} adults{{form.children > 0 ? `, ${form.children} children` : ''}}
                                </div>
                            </div>
                        </div>

                        <div class="hotel-highlights" v-if="prices">
                            <h3 class="text-lg-start m-0">Your price summary</h3>
                            <div class="d-flex flex-column gap-4 mt-4">
                                <div class="d-flex justify-content-between">
                                    <span><i class="bi bi-house me-2"></i>Room Price</span>
                                    <span> ${{ prices.totalRooms }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="bi bi-egg-fried me-2"></i>Meal Plan Price</span>
                                    <span>${{ prices.mealPlan }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="bi bi-bank me-2"></i>Tax </span>
                                    <span>${{ prices.tax }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span  class="bold text-black" style="font-weight: 700;"><i class="bi bi-wallet2 me-2"></i>Total Price</span>
                                    <span class="bold text-black" style="font-weight: 700;">${{ prices.total }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="booking-guarantees">
                            <div class="guarantee-item">
                                <i class="bi bi-shield-check"></i>
                                <span>Secure Booking</span>
                            </div>
                            <div class="guarantee-item">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span>Flexible Cancellation</span>
                            </div>
                            <div class="guarantee-item">
                                <i class="bi bi-telephone"></i>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>

                    <div class="booking-form-section col-8" data-aos="fade-right" data-aos-delay="300">
                        <div class="alert alert-danger" v-if="form.errors['rooms.0.type_id']">
                            {{ form.errors['rooms.0.type_id'] }}
                        </div>
                        <div class="form-container">
                            <form class="reservation-form" method="POST" @submit.prevent="submitForm">

                                <div class="form-section">
                                    <h4>Booking Details</h4>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="check_in" class="form-label">Check In</label>
                                            <input type="date" class="form-control" id="check_in"
                                                   v-model="form.check_in"
                                                   :min="currentDate()"
                                                   :class="{ 'is-invalid': form.errors.check_in }"
                                                   required="">
                                            <div class="invalid-feedback" v-if="form.errors.check_in">
                                                {{ form.errors.check_in }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="check_out" class="form-label">Check Out</label>
                                            <input type="date" class="form-control" id="check_out"
                                                   v-model="form.check_out"
                                                   :min="addDays(Date.now(), 1)"
                                                   :class="{ 'is-invalid': form.errors.check_out }"
                                                   required="">
                                            <div class="invalid-feedback" v-if="form.errors.check_out">
                                                {{ form.errors.check_out }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="adults" class="form-label">Adults</label>
                                            <input type="number" min="1" v-model="form.adults" class="form-control"
                                                   :class="{ 'is-invalid': form.errors.adults }"
                                                   id="adults" required="">
                                            <div class="invalid-feedback" v-if="form.errors.adults">
                                                {{ form.errors.adults }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="children" class="form-label">Children</label>
                                            <input type="number" min="0" v-model="form.children" class="form-control"
                                                   :class="{ 'is-invalid': form.errors.children }"
                                                   id="children" required="">
                                            <div class="invalid-feedback" v-if="form.errors.children">
                                                {{ form.errors.children }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="room" class="form-label">Room</label>
                                            <input type="number" min="1" v-model="form.rooms" class="form-control"
                                                   id="room"
                                                   :class="{ 'is-invalid': form.errors['rooms.0.quantity']}"
                                                   required="">
                                            <div class="invalid-feedback" v-if="form.errors['rooms.0.quantity']">
                                                {{ form.errors['rooms.0.quantity'] }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="smoking" class="form-label">Meal Plan</label>
                                            <select class="form-select"
                                                    id="smoking" :selected="form.meal_plan_id"
                                                    v-model="form.meal_plan_id"
                                                    :class="{ 'is-invalid': form.errors.meal_plan_id }">
                                                <option v-for="[id, label] in Object.entries(mealPlans)" :value="id"
                                                        :key="id">
                                                    {{ label }}
                                                </option>
                                            </select>
                                            <div class="invalid-feedback" v-if="form.errors.meal_plan_id">
                                                {{ form.errors.meal_plan_id }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4>Room Preferences</h4>
                                    <div class="form-group">
                                        <label for="smoking" class="form-label">Smoking Preference</label>
                                        <select class="form-select" id="smoking" v-model="form.smoking_preference"
                                                :class="{ 'is-invalid': form.errors.smoking_preference }">
                                            <option v-for="[id, label] in Object.entries(smoking)" :value="id"
                                                    :key="id">
                                                {{ label }}
                                            </option>
                                        </select>
                                        <div class="invalid-feedback" v-if="form.errors.smoking_preference">
                                            {{ form.errors.smoking_preference }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="additional-notes" class="form-label">Additional Requirements</label>
                                        <textarea class="form-control" id="additional-notes"
                                                  v-model="form.special_requests"
                                                  rows="3"
                                                  placeholder="Please specify any special arrangements or preferences..."></textarea>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4>Guest Information</h4>
                                    <div class="form-grid">
                                        <div class="form-group full-width">
                                            <label for="primary-guest" class="form-label">Primary Guest Name</label>
                                            <input type="text" class="form-control" id="primary-guest"
                                                   :value="customer.full_name"
                                                   name="primary_guest" required="" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="contact-email"
                                                   :value="customer.email"
                                                   name="contact_email" required="" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-phone" class="form-label">Mobile</label>
                                            <input type="tel" class="form-control" id="contact-phone"
                                                   :value="customer.mobile"
                                                   name="contact_phone" required="" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-calendar-plus me-2"></i>
                                        Submit Reservation Request
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Booking Section -->
</template>

<script setup>
import {defineProps, onMounted, ref, watch} from "vue";
import {useEnum} from "../../Composables/useEnum.js";
import {useForm, usePage} from "@inertiajs/vue3";
import {addDays, currentDate, diffDays} from "../../Utils/helper.js";
import moment from "moment/moment.js";

const {props: {auth: {customer}}} = usePage();

const {filters, smokingPreferences, roomType, mealPlans} = defineProps({
    filters: Object,
    smokingPreferences: Array,
    roomType: Object,
    mealPlans: Object,
});

const {
    select: smoking,
    default: defaultSmoking,
} = useEnum(smokingPreferences)

const prices = ref(null);

const form = useForm({
    adults: filters.adults ?? 2,
    children: filters.children ?? 0,
    check_in: filters.check_in ?? '',
    check_out: filters.check_out ?? '',
    rooms: filters.rooms ?? 1,
    smoking_preference: defaultSmoking,
    room_type_id: roomType.id,
    meal_plan_id: 1,
    special_requests: '',
    children_age: [],
})

onMounted(() => {
    const {adults, children, rooms, meal_plan_id, children_age, check_in, check_out} = form;
    if (adults && children && rooms && meal_plan_id && children_age && check_in && check_out) {
        showPrices([adults, children, rooms, meal_plan_id, children_age, check_in, check_out]);
    }
})

watch(
    () => [form.adults, form.children, form.rooms, form.meal_plan_id, form.children_age, form.check_in, form.check_out],
    (inputs) => {
        if (inputs.some(val => val === "")) {
            if(prices) prices.value = null
            return;
        }
        showPrices(inputs)
    }, {
        deep: true
    });

const showPrices = (inputs) => {
    const [adults, children, rooms, meal_plan_id, children_age, check_in, check_out] = inputs;
    const nights = diffDays(check_in, check_out);

    const mutatedRooms = [
        {
            'type_id': form.room_type_id,
            'quantity': rooms
        }
    ]

    axios.post(route('bookings.prices'), {
        adults,
        children,
        rooms: mutatedRooms,
        meal_plan_id,
        children_age,
        nights
    })
        .then(res => {
                prices.value = {...res.data, nights};
            }
        )
}

const submitForm = () => {
    form.post(route('bookings.store'))
}
</script>

<style scoped>
.hotel-highlights i {
    color: var(--accent-color);
    font-size: 16px;
}
</style>
