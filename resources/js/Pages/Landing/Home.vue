<template>
    <!-- Hotel Hero Section -->
    <section id="hotel-hero" class="hotel-hero section hotel-hero-bg">
        <div class="hero-content w-full">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <div class="hero-text aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                            <h1 class="text-white">Luxury Redefined</h1>
                            <p class="hero-subtitle text-white">Experience unparalleled comfort and elegance in the
                                heart of the city. Where every moment becomes a cherished memory.</p>
                            <div class="hero-actions aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                <a href="booking.html" class="btn btn-origin p-5 py-3 mx-3" style="border-radius: 50px">Book
                                    Your Stay</a>
                                <a href="amenities.html" class="btn btn-outline p-5 py-3" style="border-radius: 50px">Explore
                                    Amenities</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <div class="col-lg-10">
                        <div class="booking-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                            <form class="booking-form php-email-form" method="post">
                                <div class="row align-items-end g-3">
                                    <div class="col-md-3">
                                        <label for="checkin" class="form-label">Check-in</label>
                                        <input type="date" class="form-control" id="checkin" name="checkin" required="">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="checkout" class="form-label">Check-out</label>
                                        <input type="date" class="form-control" id="checkout" name="checkout"
                                               required="">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="guests" class="form-label">Guests</label>
                                        <select class="form-select" id="guests" name="guests" required="">
                                            <option value="">Select</option>
                                            <option value="1">1 Guest</option>
                                            <option value="2">2 Guests</option>
                                            <option value="3">3 Guests</option>
                                            <option value="4">4 Guests</option>
                                            <option value="5">5+ Guests</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="rooms" class="form-label">Rooms</label>
                                        <select class="form-select" id="rooms" name="rooms" required="">
                                            <option value="">Select</option>
                                            <option value="1">1 Room</option>
                                            <option value="2">2 Rooms</option>
                                            <option value="3">3 Rooms</option>
                                            <option value="4">4+ Rooms</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-origin">
                                            <i class="bi bi-search"></i>
                                            <span class="mx-2">Search</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-4">
                    <div class="col-lg-10">
                        <div class="hotel-highlights aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                            <div class="row text-center">
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-wifi"></i>
                                        <div>Free WiFi</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-p-circle"></i>
                                        <div>Free Parking</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-cup-hot"></i>
                                        <div>Room Service</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="highlight-item">
                                        <i class="bi bi-water"></i>
                                        <div>Swimming Pool</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Hotel Hero Section -->


    <!-- About Home Section -->
    <section id="about-home" class="about-home section light-background">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4 align-items-center">

                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                    <div class="about-content">
                        <h2>Welcome to Grandoria Resort</h2>
                        <p class="lead">Where luxury meets tranquility in the heart of nature's paradise.</p>
                        <p>Nestled among rolling hills and pristine landscapes, Grandview Resort has been offering
                            exceptional hospitality for over three decades. Our commitment to excellence and attention
                            to detail creates an unforgettable experience for discerning travelers seeking both comfort
                            and adventure.</p>
                        <p>From our elegantly appointed suites to our world-class amenities, every aspect of your stay
                            is designed to exceed expectations. Discover breathtaking views, exquisite dining, and
                            personalized service that makes every moment special.</p>

                        <div class="stats-row">
                            <div class="stat-item">
                                <div class="stat-number">185</div>
                                <div class="stat-label">Luxury Rooms</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">98%</div>
                                <div class="stat-label">Guest Satisfaction</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">30</div>
                                <div class="stat-label">Years of Excellence</div>
                            </div>
                        </div><!-- End Stats Row -->

                        <div class="about-actions">
                            <a href="about.html" class="btn-primary">Our Story</a>
                            <a href="rooms.html" class="btn-secondary">View Rooms</a>
                        </div>
                    </div>
                </div><!-- End About Content -->

                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="about-images">
                        <div class="main-image">
                            <img src="/resources/images/showcase-8.webp" alt="Grandview Resort Main View"
                                 class="img-fluid">
                        </div>
                        <div class="secondary-image">
                            <img src="/resources/images/room-12.webp" alt="Luxury Suite Interior" class="img-fluid">
                        </div>
                        <div class="experience-badge">
                            <div class="badge-content">
                                <span class="badge-number">30+</span>
                                <span class="badge-text">Years<br>Experience</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End About Images -->

            </div>

        </div>

    </section><!-- /About Home Section -->


    <!-- Rooms Showcase Section -->
    <section id="rooms-showcase" class="rooms-showcase section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span class="description-title">Rooms</span>
            <h2>Rooms</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row mt-6">
                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Classic Room" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Classic Double</h5>
                            <div class="price-tag">$189<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-wifi"></i>
                                <i class="bi bi-tv"></i>
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="450">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Superior Room" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Superior King</h5>
                            <div class="price-tag">$249<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-wifi"></i>
                                <i class="bi bi-cup-hot"></i>
                                <i class="bi bi-snow"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Premium Room" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Premium Ocean View</h5>
                            <div class="price-tag">$359<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-water"></i>
                                <i class="bi bi-door-open"></i>
                                <i class="bi bi-award"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="550">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Luxury Suite" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Luxury Penthouse</h5>
                            <div class="price-tag">$1,199<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-star"></i>
                                <i class="bi bi-house"></i>
                                <i class="bi bi-gem"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

            </div>
            <div class="row mt-6">
                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Classic Room" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Classic Double</h5>
                            <div class="price-tag">$189<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-wifi"></i>
                                <i class="bi bi-tv"></i>
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="450">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Superior Room" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Superior King</h5>
                            <div class="price-tag">$249<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-wifi"></i>
                                <i class="bi bi-cup-hot"></i>
                                <i class="bi bi-snow"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Premium Room" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Premium Ocean View</h5>
                            <div class="price-tag">$359<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-water"></i>
                                <i class="bi bi-door-open"></i>
                                <i class="bi bi-award"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

                <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="550">
                    <div class="minimal-room-card">
                        <div class="room-image">
                            <img src="/resources/images/room-12.webp" alt="Luxury Suite" class="img-fluid">
                            <div class="hover-overlay">
                                <a href="room-details.html" class="view-room">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="room-summary">
                            <h5>Luxury Penthouse</h5>
                            <div class="price-tag">$1,199<span>/night</span></div>
                            <div class="basic-amenities">
                                <i class="bi bi-star"></i>
                                <i class="bi bi-house"></i>
                                <i class="bi bi-gem"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- End Minimal Room -->

            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                <a href="rooms.html" class="explore-all-link">
                    <span>Explore All Accommodations</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </div>

    </section><!-- /Rooms Showcase Section -->

    <!-- Amenities Cards Section -->
    <section id="amenities-cards" class="amenities-cards section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span class="description-title">Amenities</span>
            <h2>Amenities</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-5">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Wireless Internet" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-wifi"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>High-Speed Internet</h4>
                            <p>Complimentary wireless internet access throughout the hotel premises with
                                enterprise-grade security and unlimited bandwidth for all your connectivity needs.</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> 24/7 Available</span>
                                <span><i class="bi bi-check-circle"></i> High Speed</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Swimming Pool" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-droplet"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>Rooftop Pool</h4>
                            <p>Luxurious rooftop swimming pool with breathtaking city skyline views. Features heated
                                water, poolside service, and premium lounging areas for ultimate relaxation.</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> Heated Pool</span>
                                <span><i class="bi bi-check-circle"></i> City Views</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Valet Parking" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-car-front"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>Valet Parking</h4>
                            <p>Premium valet parking service with secure underground facility. Professional attendants
                                ensure your vehicle is safely parked and readily available upon request.</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> Secure</span>
                                <span><i class="bi bi-check-circle"></i> Valet Service</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Fitness Center" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>Modern Fitness Center</h4>
                            <p>Cutting-edge fitness facility featuring premium equipment, personal training services,
                                and wellness programs designed to maintain your health routine while traveling.</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> 24/7 Access</span>
                                <span><i class="bi bi-check-circle"></i> Personal Training</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Fine Dining" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>Signature Restaurant</h4>
                            <p>Award-winning culinary experience featuring international cuisine crafted by renowned
                                chefs. Elegant atmosphere with extensive wine selection and impeccable service.</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> Fine Dining</span>
                                <span><i class="bi bi-check-circle"></i> Wine Selection</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="/resources/images/showcase-8.webp" alt="Spa Services" class="img-fluid">
                            <div class="facility-overlay">
                                <i class="bi bi-flower1"></i>
                            </div>
                        </div>
                        <div class="facility-info">
                            <h4>Luxury Spa</h4>
                            <p>Tranquil sanctuary offering therapeutic treatments, rejuvenating massages, and holistic
                                wellness experiences. Escape the everyday stress in our serene environment.</p>
                            <div class="facility-features">
                                <span><i class="bi bi-check-circle"></i> Full Service</span>
                                <span><i class="bi bi-check-circle"></i> Wellness Programs</span>
                            </div>
                        </div>
                    </div>
                </div><!-- End Facility Card -->

            </div>

        </div>

    </section><!-- /Amenities Cards Section -->


    <!-- Gallery Showcase Section -->
    <section id="gallery-showcase" class="gallery-showcase section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="gallery-carousel swiper init-swiper" data-aos="fade-up" data-aos-delay="200">
                <swiper
                    :slides-per-view="1"
                    :space-between="20"
                    loop
                    :autoplay="{'delay': 3000 }"
                    centered-slides
                    :speed="600"
                    :breakpoints="{
                        '576': {
                        'slidesPerView': 2,
                        'centeredSlides': false
                        },
                        '768': {
                        'slidesPerView': 3,
                        'centeredSlides': false
                        },
                        '992': {
                        'slidesPerView': 4,
                        'centeredSlides': false
                        },
                        '1200': {
                        'slidesPerView': 5,
                        'centeredSlides': false
                        }
                    }">
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/bg-hero.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/bg-hero.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>
                    <swiper-slide class="swiper-slide">
                        <div class="gallery-item">
                            <img src="/resources/images/room-12.webp" alt="Luxurious Suite" class="img-fluid"
                                 loading="lazy">
                            <a href="/resources/images/room-12.webp" class="gallery-overlay glightbox">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </swiper-slide>

                </swiper>
            </div>

            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300">
                <a href="gallery.html" class="btn btn-gallery">
                    <i class="bi bi-collection me-2"></i>Discover Our Full Gallery
                </a>
            </div>

        </div>

    </section><!-- /Gallery Showcase Section -->

</template>

<script setup>
import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/css';


</script>
