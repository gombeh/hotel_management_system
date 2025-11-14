<template>
    <Head>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet">
    </Head>
    <Header/>
    <main class="main">
        <slot/>
    </main>
</template>

<script setup>
import Header from "./Header.vue";
import "../../../css/bootstrap.min.css"
import "../../../css/landing.css"
import "../../../css/bootstrap-icons.css"
import {usePage} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {watch} from "vue";

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
                margin: "200px",
            });
        }
    },
    { deep: true, immediate: true }
);
</script>
