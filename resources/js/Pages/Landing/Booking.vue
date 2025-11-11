<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Booking</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><Link :href="route('home')">Home</Link></li>
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

                <div class="booking-grid">
                    <div class="booking-form-section" data-aos="fade-right" data-aos-delay="300">
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
                                            <input type="date" class="form-control" id="check_in" v-model="form.check_in"
                                                   :class="{ 'is-invalid': form.errors.check_in }"
                                                    required="">
                                            <div class="invalid-feedback" v-if="form.errors.check_in">
                                                {{ form.errors.check_in }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="check_out" class="form-label">Check Out</label>
                                            <input type="date" class="form-control" id="check_out" v-model="form.check_out"
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
                                            <input type="number" min="1" v-model="form.rooms" class="form-control" id="room"
                                                   :class="{ 'is-invalid': form.errors['rooms.0.quantity']}"
                                                   required="">
                                            <div class="invalid-feedback" v-if="form.errors['rooms.0.quantity']">
                                                {{ form.errors['rooms.0.quantity'] }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="smoking" class="form-label">Meal Plan</label>
                                            <select class="form-select"
                                                    id="smoking" :selected="form.meal_plan_id" v-model="form.meal_plan_id" :class="{ 'is-invalid': form.errors.meal_plan_id }">
                                                <option v-for="[id, label] in Object.entries(mealPlans)" :value="id" :key="id">
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
                                        <select class="form-select" id="smoking" v-model="form.smoking_preference" :class="{ 'is-invalid': form.errors.smoking_preference }">
                                            <option v-for="[id, label] in Object.entries(smoking)" :value="id" :key="id">
                                                {{ label }}
                                            </option>
                                        </select>
                                        <div class="invalid-feedback" v-if="form.errors.smoking_preference">
                                            {{ form.errors.smoking_preference }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="additional-notes" class="form-label">Additional Requirements</label>
                                        <textarea class="form-control" id="additional-notes" v-model="form.special_requests"
                                                  rows="3"
                                                  placeholder="Please specify any special arrangements or preferences..."></textarea>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4>Guest Information</h4>
                                    <div class="form-grid">
                                        <div class="form-group full-width">
                                            <label for="primary-guest" class="form-label">Primary Guest Name</label>
                                            <input type="text" class="form-control" id="primary-guest" :value="customer.full_name"
                                                   name="primary_guest" required="" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="contact-email" :value="customer.email"
                                                   name="contact_email" required="" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-phone" class="form-label">Mobile</label>
                                            <input type="tel" class="form-control" id="contact-phone" :value="customer.mobile"
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

                    <div class="hotel-showcase" data-aos="fade-left" data-aos-delay="400">
                        <div class="showcase-image">
                            <img :src="roomType.mainImage[0].url" alt="Hotel luxury showcase" class="img-fluid">
                        </div>

                        <div class="hotel-highlights">
                            <h3>Why Choose Our Hotel</h3>
                            <div class="highlights-grid">
                                <div class="highlight-item">
                                    <div class="highlight-icon">
                                        <i class="bi bi-wifi"></i>
                                    </div>
                                    <div class="highlight-content">
                                        <h5>Premium Connectivity</h5>
                                        <p>High-speed internet access in all areas</p>
                                    </div>
                                </div>
                                <div class="highlight-item">
                                    <div class="highlight-icon">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="highlight-content">
                                        <h5>24/7 Service</h5>
                                        <p>Round-the-clock assistance and support</p>
                                    </div>
                                </div>
                                <div class="highlight-item">
                                    <div class="highlight-icon">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                    <div class="highlight-content">
                                        <h5>Valet Parking</h5>
                                        <p>Complimentary parking with valet service</p>
                                    </div>
                                </div>
                                <div class="highlight-item">
                                    <div class="highlight-icon">
                                        <i class="bi bi-heart-pulse"></i>
                                    </div>
                                    <div class="highlight-content">
                                        <h5>Wellness Center</h5>
                                        <p>Full-service spa and fitness facilities</p>
                                    </div>
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

                </div>

            </div>

        </div>

    </section><!-- /Booking Section -->
</template>

<script setup>
import {defineProps} from "vue";
import {useEnum} from "../../Composables/useEnum.js";
import {useForm, usePage} from "@inertiajs/vue3";
const {props: {auth:{customer}}} = usePage();

const {filters, smokingPreferences, roomType, mealPlans} = defineProps({
    filters: Array,
    smokingPreferences: Array,
    roomType: Object,
    mealPlans: Object,
});

const {
    select: smoking,
    default: defaultSmoking,
} = useEnum(smokingPreferences)

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

const submitForm = () => {
    form.post(route('bookings.store'))
}
</script>
