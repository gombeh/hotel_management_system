<template>
    <div class="page">
        <TopHeader/>
        <MainHeader/>
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <slot/>
                </div>
            </div>
            <Footer/>
        </div>
    </div>
</template>

<script setup lang="ts">
import TopHeader from "./TopHeader.vue";
import MainHeader from "./MainHeader.vue";
import Footer from "./Footer.vue";
</script>
