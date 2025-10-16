<template>
    <header id="header" class="header sticky-top">
        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="index.html" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="assets/img/logo.webp" alt=""> -->
                    <h1 class="sitename d-flex align-items-center gap-1">
                        <img src="/resources/images/Homa.png" alt="logo"
                             style="width: 50px; height: 50px; filter: brightness(0) invert(1)"/>
                        <Link class="d-inline-block mt-1" :href="route('home')"> Homa</Link>
                    </h1>
                </a>
            </div>
        </div>
    </header>
</template>


<script setup>

</script>

