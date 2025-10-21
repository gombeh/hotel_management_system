<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Rooms</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Rooms</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Rooms 2 Section -->
    <section id="rooms-2" class="rooms-2 section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="room-filters" data-aos="fade-up" data-aos-delay="200">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Price Range</label>
                        <select class="form-select">
                            <option>All Prices</option>
                            <option>$100 - $200</option>
                            <option>$200 - $350</option>
                            <option>$350+</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Guest Capacity</label>
                        <select class="form-select">
                            <option>Any Capacity</option>
                            <option>1-2 Guests</option>
                            <option>3-4 Guests</option>
                            <option>5+ Guests</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">View Type</label>
                        <select class="form-select">
                            <option>All Views</option>
                            <option>Ocean View</option>
                            <option>City View</option>
                            <option>Garden View</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Sort By</label>
                        <select class="form-select">
                            <option>Popularity</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Room Size</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="rooms-grid" data-aos="fade-up" data-aos-delay="300">
                <div class="row g-4">

                    <div class="col-xl-4 col-lg-6" v-for="roomType in roomTypes.data">
                        <div class="room-card">
                            <div class="room-image">
                                <img :src="roomType.mainImage[0]?.url" alt="Deluxe Ocean Suite" class="img-fluid">
                                <div class="room-features">
                                    <span class="feature-badge ocean">Ocean View</span>
                                    <span class="feature-badge popular">Popular</span>
                                </div>
                            </div>
                            <div class="room-content">
                                <div class="room-header">
                                    <h3>{{ roomType.name }}</h3>
                                    <div class="room-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                                <p class="room-description" v-html="roomType.short_description"></p>
                                <div class="room-amenities">
                                    <span><i class="bi bi-people"></i> Up to 4 guests</span>
                                    <span><i class="bi bi-wifi"></i> Free WiFi</span>
                                    <span><i class="bi bi-tv"></i> Smart TV</span>
                                </div>
                                <div class="room-footer">
                                    <div class="room-price">
                                        <span class="price-from">From</span>
                                        <span class="price-amount">${{ roomType.price }}</span>
                                        <span class="price-period">/ night</span>
                                    </div>
                                    <Link :href="route('roomTypes.show', roomType.slug)" class="btn-room-details">View Details</Link>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Room Card -->
                </div>
            </div>

            <div class="load-more-section" data-aos="fade-up" data-aos-delay="400">
                <div class="text-center">
                    <button class="btn-load-more">
                        <i class="bi bi-arrow-down-circle"></i>
                        Load More Rooms
                    </button>
                </div>
            </div>

        </div>

    </section><!-- /Rooms 2 Section -->
</template>

<script setup>
defineProps({
    roomTypes: Object
})
</script>
