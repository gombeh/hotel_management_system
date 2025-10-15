<template>
    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center dark-background">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="index.html" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="assets/img/logo.webp" alt=""> -->
                    <h1 class="sitename">Grandoria</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="index.html" class="active">Home</a></li>
                        <li><a href="rooms.html">Rooms</a></li>
                        <li><a href="amenities.html">Amenities</a></li>
                        <li><a href="about.html">About</a></li>
                        <span style="font-size: 20px">|</span>
                        <li v-if="!customer"><a :href="route('login')">Login</a></li>
                        <li class="dropdown" v-if="customer">
                            <a href="#profile">
                            <div class="rounded-5 me-2 mx-1" style="background: #ffb700; round: 100%; overflow: hidden">
                                <img  width="30" height="30" :src="customer.avatar" alt="avtar" />
                            </div>
                            <span class="me-1">{{customer.full_name}}</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
                            <ul>
                                <li>
                                    <Link href="#french" class="d-inline-block">
                                        <i class="bi bi-person me-2" style="font-size: 18px"></i>
                                        <span>My Account</span>
                                    </Link>
                                </li>
                                <li>
                                    <a href="" @click.prevent="logoutHandle" class="d-inline-block">
                                        <i class="bi bi-box-arrow-left me-2" style="font-size: 18px"></i>
                                        <span>Sign Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>

        </div>

    </header>
</template>


<script setup>
import {router, usePage} from "@inertiajs/vue3";

const {props: {auth: {customer}}} = usePage();

const logoutHandle = () => {
    router.delete(route('logout'), {
        onSuccess: () => {
            window.location.reload();
        }
    })
}
</script>

