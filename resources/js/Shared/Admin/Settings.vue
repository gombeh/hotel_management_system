<template>
    <div class="navbar-nav flex-row order-md-last">
        <div class="nav-item d-none d-md-flex me-3">
            <div class="btn-list">
                <a href="https://github.com/gombeh/hotel_management_system" class="btn btn-5" target="_blank"
                   rel="noreferrer">
                    <IconBrandGithub class="icon icon-2"/>
                    Source code
                </a>
                <a href="https://github.com/sponsors/codecalm" class="btn btn-6" target="_blank" rel="noreferrer">
                    <IconHeart class="icon icon-2 text-pink"/>
                    Sponsor
                </a>
            </div>
        </div>
        <div class="d-none d-md-flex">
            <div class="nav-item">
                <a href=""
                   class="nav-link px-0"
                   :title="`Enable ${theme === 'dark' ? 'light' : 'dark' } mode`"
                   data-bs-toggle="tooltip"
                   data-bs-placement="bottom"
                   @click.prevent="toggleTheme"
                >
                    <IconSun class="icon icon-1" v-if="theme === 'dark'"/>
                    <IconMoon class="icon icon-1" v-else/>
                </a>
            </div>
            <div class="nav-item dropdown d-none d-md-flex">
                <a
                    href="#"
                    class="nav-link px-0"
                    data-bs-toggle="dropdown"
                    tabindex="-1"
                    aria-label="Show notifications"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                >
                    <IconBell class="icon icon-1"/>
                    <span class="badge bg-red"></span>
                </a>
                <Notifications/>
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#"
                  class="nav-link d-flex lh-1 p-0 px-2"
                  data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm">
                    <img :src="getMediaUrl(user.avatar[0], 'thumb')" alt="avatar" />
                </span>
                <div class="d-none d-xl-block ps-2">
                    <div>{{ user.full_name }}</div>
                    <div class="mt-1 small text-secondary">{{user.roles?.map(role => role.name).join(', ')}}</div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <Link :href="route('admin.profile.edit')" class="dropdown-item">Profile</Link>
                <Link :href="route('admin.password.edit')" class="dropdown-item">Change Password</Link>
                <div class="dropdown-divider"></div>
                <Link :href="route('admin.logout')" method="DELETE" class="dropdown-item">Logout</Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import Notifications from "./Notifications.vue";
import {useTheme} from "../../Composables/useTheme.js";
import {IconSun, IconMoon, IconBell, IconBrandGithub, IconHeart} from "@tabler/icons-vue";
import {usePage} from "@inertiajs/vue3";
import {getMediaUrl} from "../../Utils/helper.js";

const {theme, toggleTheme} = useTheme()
const {props:{auth: {user}}} = usePage()

</script>
