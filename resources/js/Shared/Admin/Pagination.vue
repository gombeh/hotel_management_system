<template>
    <ul class="pagination m-0 ms-auto">
        <li
            :key="index"
            v-for="(link, index) in links"
            :class="{
                'active': link.active,
                'disabled': !link.url
            }"
            class="page-item">
            <Link class="page-link cursor-pointer" :href="link.url ?? ''">
                <Prev v-if="index===0" />
                <Next v-else-if="index===(links.length - 1)" />
                <span v-else>{{link.label}}</span>
            </Link>
        </li>
    </ul>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Next from "../../Components/Svg/Next.vue";
import Prev from "../../Components/Svg/Prev.vue";

defineProps({
    links: Array
})

</script>
