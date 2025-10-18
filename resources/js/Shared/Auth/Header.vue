<template>
    <header id="header" class="header sticky-top">
        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <Link :href="route('home')">
                    <h1 class="sitename d-flex align-items-center gap-1 my-1">
                        <img src="/resources/images/Homa.png" alt="logo"
                             style="width: 40px; height: 40px; filter: brightness(0) invert(1)"/>
                        <span class="px-1">Homa</span>
                    </h1>
                </Link>
            </div>
        </div>
    </header>
</template>


<script setup>

</script>

