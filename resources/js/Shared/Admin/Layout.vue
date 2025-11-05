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
import {useToast} from "vue-toastification";
import {usePage} from "@inertiajs/vue3";
import {watch} from "vue";
import "@tabler/core/dist/css/tabler.min.css";


const page = usePage();
const toast = useToast();

watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.message) {
            toast[flash?.type ?? 'success'](flash.message, {
                position: "top-right",
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                closeButton: "button",
            });
        }
    },
    { deep: true, immediate: true }
);


</script>
