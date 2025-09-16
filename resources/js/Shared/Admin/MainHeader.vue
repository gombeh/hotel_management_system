<template>
    <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar">
                <div class="container-xl">
                    <div class="row flex-column flex-md-row flex-fill align-items-center">
                        <div class="col">
                            <!-- BEGIN NAVBAR MENU -->
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="./">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block"><IconHome class="icon" /></span>
                                        <span class="nav-link-title"> Home </span>
                                    </a>
                                </li>
                                <li class="nav-item active dropdown">
                                    <a
                                        class="nav-link dropdown-toggle"
                                        href="#navbar-base"
                                        data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside"
                                        role="button"
                                        aria-expanded="false"
                                    >
                                        <span class="nav-link-icon d-md-none d-lg-inline-block"><IconUsers class="icon"/></span>
                                        <span class="nav-link-title"> People </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <Link class="dropdown-item" :href="route('admin.users.index')">
                                                    Users
                                                </Link>
                                                <Link class="dropdown-item" :href="route('admin.roles.index')">
                                                    Roles
                                                </Link>
                                                <a class="dropdown-item" href="./markdown.html"> Customers </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- END NAVBAR MENU -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
<script setup lang="ts">
import {IconHome, IconUsers} from "@tabler/icons-vue"
import { Link } from '@inertiajs/vue3'
</script>
