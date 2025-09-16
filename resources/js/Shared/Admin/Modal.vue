<template>
    <Teleport to="body">
        <div class="modal modal-blur fade rounded d-block show bg-surface-backdrop py-6 w-full h-full fixed-top">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ title }}</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <slot />
                    </div>
                    <div class="modal-footer">
                        <button @click="closeModal" class="btn btn-link link-secondary btn-3" > Cancel </button>
                        <button href="#" class="btn btn-primary btn-5 ms-auto" :form="formId">
                            <IconDeviceFloppy class="icon" />
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
<script setup>
    import {IconDeviceFloppy} from "@tabler/icons-vue"
    import {inject, onUnmounted} from "vue";

    defineProps({
        title: String,
        formId: String,
    })
    const closeModal = inject('closeModal');

    document.body.style.overflow = 'hidden'

    onUnmounted(() => document.body.style.overflow = 'auto')
</script>
