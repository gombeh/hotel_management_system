<template>
    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Room Details</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Room Details</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Room Details Section -->
    <section id="room-details" class="room-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <!-- Room Header with Image and Basic Info -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-7" data-aos="fade-right" data-aos-delay="200">
                    <div class="room-header-image">
                        <img :src="roomType.mainImage[0].url" :alt="roomType.name" class="img-fluid rounded">
                        <div class="room-badge">
                            <span class="text-white">Premium Suite</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" data-aos="fade-left" data-aos-delay="300">
                    <div class="room-header-content">
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
                        <h1 class="room-title">{{ roomType.name}}</h1>
                        <p class="room-tagline" v-html="roomType.short_description"></p>
                        <div class="room-capacity mb-4">
                            <div class="capacity-item">
                                <i class="bi bi-people"></i>
                                <span>Up to {{roomType.max_total_guests}} guests</span>
                            </div>
                            <div class="capacity-item">
                                <i class="bi bi-grid"></i>
                                <span>{{ roomType.size }} m²</span>
                            </div>
                            <div class="capacity-item">
                                <i class="bi bi-bed"></i>
                                <span>King bed + Sofa bed</span>
                            </div>
                        </div>
                        <div class="room-price">
                            <span class="price-amount">${{ roomType.price }}</span>
                            <span class="price-period">per night</span>
                        </div>
                        <a href="booking.html" class="btn btn-book-now">Book Now</a>
                    </div>
                </div>
            </div>

            <!-- Room Gallery -->
            <div class="room-gallery mb-5" data-aos="fade-up" data-aos-delay="200">
                <h3 class="section-subtitle mb-4">Room Gallery</h3>
                <div class="gallery-grid">
                    <div class="gallery-main">
                        <a href="/resources/images/room-12.webp" class="glightbox">
                            <img src="/resources/images/room-12.webp" alt="Suite Interior" class="img-fluid">
                        </a>
                    </div>
                    <div class="gallery-thumbnails">
                        <a href="/resources/images/room-12.webp" class="glightbox">
                            <img src="/resources/images/room-12.webp" alt="Bedroom View" class="img-fluid">
                        </a>
                        <a href="/resources/images/room-12.webp" class="glightbox">
                            <img src="/resources/images/room-12.webp" alt="Living Area" class="img-fluid">
                        </a>
                        <a href="/resources/images/room-12.webp" class="glightbox">
                            <img src="/resources/images/room-12.webp" alt="Ocean View" class="img-fluid">
                        </a>
                        <a href="/resources/images/room-12.webp" class="glightbox">
                            <img src="/resources/images/room-12.webp" alt="Bathroom" class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Room Description -->
            <div class="row mb-5">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="room-description" v-html="roomType.description">
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="highlight-box">
                        <div class="highlight-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <h4>Premium Experience</h4>
                        <p>"The most beautiful suite we've ever stayed in. The ocean view is absolutely breathtaking and the attention to detail is remarkable."</p>
                        <div class="quote-author">
                            <span>- Sarah M., Verified Guest</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amenities and Features -->
            <div class="room-amenities mb-5" data-aos="fade-up" data-aos-delay="200">
                <h3 class="section-subtitle mb-4">Room Amenities</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="amenity-category">
                            <h5>Sleeping</h5>
                            <ul>
                                <li><i class="bi bi-check2"></i> King size bed</li>
                                <li><i class="bi bi-check2"></i> Premium linens</li>
                                <li><i class="bi bi-check2"></i> Memory foam pillows</li>
                                <li><i class="bi bi-check2"></i> Blackout curtains</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="amenity-category">
                            <h5>Technology</h5>
                            <ul>
                                <li><i class="bi bi-check2"></i> High-speed WiFi</li>
                                <li><i class="bi bi-check2"></i> 55" Smart TV</li>
                                <li><i class="bi bi-check2"></i> Bluetooth speakers</li>
                                <li><i class="bi bi-check2"></i> USB charging ports</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="amenity-category">
                            <h5>Comfort</h5>
                            <ul>
                                <li><i class="bi bi-check2"></i> Climate control</li>
                                <li><i class="bi bi-check2"></i> Mini refrigerator</li>
                                <li><i class="bi bi-check2"></i> Coffee machine</li>
                                <li><i class="bi bi-check2"></i> Safe deposit box</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="amenity-category">
                            <h5>Bathroom</h5>
                            <ul>
                                <li><i class="bi bi-check2"></i> Marble bathroom</li>
                                <li><i class="bi bi-check2"></i> Rain shower</li>
                                <li><i class="bi bi-check2"></i> Luxury toiletries</li>
                                <li><i class="bi bi-check2"></i> Heated floors</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabbed Information -->
            <div class="room-tabs mb-5" data-aos="fade-up" data-aos-delay="200">
                <ul class="nav nav-tabs" id="room-detailsRoomTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="room-details-policies-tab" data-bs-toggle="tab" data-bs-target="#room-details-policies" type="button" role="tab">Policies</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="room-details-location-tab" data-bs-toggle="tab" data-bs-target="#room-details-location" type="button" role="tab">Location</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="room-details-services-tab" data-bs-toggle="tab" data-bs-target="#room-details-services" type="button" role="tab">Services</button>
                    </li>
                </ul>
                <div class="tab-content" id="room-detailsRoomTabsContent">
                    <div class="tab-pane fade show active" id="room-details-policies" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>Check-in / Check-out</h6>
                                    <p>Check-in: 3:00 PM<br>Check-out: 11:00 AM</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>Cancellation</h6>
                                    <p>Free cancellation up to 24 hours before arrival</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>Pets</h6>
                                    <p>Pet-friendly with additional fee</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="room-details-location" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Nearby Attractions</h6>
                                    <ul>
                                        <li>Beach access - 2 minutes walk</li>
                                        <li>Marina District - 0.5 miles</li>
                                        <li>Historic Downtown - 1.2 miles</li>
                                        <li>Shopping Center - 0.8 miles</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>Transportation</h6>
                                    <ul>
                                        <li>Airport shuttle available</li>
                                        <li>Valet parking - $25/night</li>
                                        <li>Public transportation nearby</li>
                                        <li>Car rental desk in lobby</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="room-details-services" role="tabpanel">
                        <div class="tab-content-wrapper">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>Concierge</h6>
                                    <p>24/7 concierge service for reservations and recommendations</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>Room Service</h6>
                                    <p>Available 6:00 AM - 11:00 PM daily</p>
                                </div>
                                <div class="col-md-4">
                                    <h6>Housekeeping</h6>
                                    <p>Daily housekeeping and turndown service</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Optional Add-ons -->
            <div class="room-addons mb-5" data-aos="fade-up" data-aos-delay="200">
                <h3 class="section-subtitle mb-4">Enhance Your Stay</h3>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="addon-card">
                            <div class="addon-icon">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <h5>Breakfast Package</h5>
                            <p>Start your day with our signature breakfast buffet featuring fresh local ingredients</p>
                            <div class="addon-price">+$35 per person</div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="addon-card">
                            <div class="addon-icon">
                                <i class="bi bi-flower1"></i>
                            </div>
                            <h5>Spa Access</h5>
                            <p>Enjoy unlimited access to our luxury spa facilities during your stay</p>
                            <div class="addon-price">+$75 per day</div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="addon-card">
                            <div class="addon-icon">
                                <i class="bi bi-airplane"></i>
                            </div>
                            <h5>Airport Transfer</h5>
                            <p>Private luxury vehicle transfer to and from the airport</p>
                            <div class="addon-price">+$95 round trip</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking CTA -->
            <div class="booking-cta" data-aos="fade-up" data-aos-delay="200">
                <div class="booking-card">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h4>Ready to book your stay?</h4>
                            <p>Experience luxury and comfort in our Deluxe Ocean View Suite. Book now and create unforgettable memories.</p>
                        </div>
                        <div class="col-lg-4 text-center text-lg-end">
                            <div class="price-display">
                                <span class="price">$395</span>
                                <span class="period">per night</span>
                            </div>
                            <a href="booking.html" class="btn btn-primary btn-lg">Check Availability</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section><!-- /Room Details Section -->
</template>

<script setup>
defineProps({
    roomType: Object,
})
</script>
