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
                <IconChevronLeft class="icon" v-if="index===0" />
                <IconChevronRight class="icon" v-else-if="index===(links.length - 1)" />
                <span v-else>{{link.label}}</span>
            </Link>
        </li>
    </ul>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

import {IconChevronRight, IconChevronLeft} from "@tabler/icons-vue"

defineProps({
    links: Array
})

</script>
