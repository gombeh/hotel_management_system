<template>
    <Head title="show customer"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">{{ customer.full_name }} Customer</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.customers.index')">
                <IconArrowLeft class="icon"/>
                Back
            </Link>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row g-2 align-items-center w-full my-2">
                    <span class="col m-0">Base info</span>
                </div>
            </div>
            <div class="card-body py-5 px-3">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Full Name</div>
                        <div class="datagrid-content">{{ customer.full_name }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Email</div>
                        <div class="datagrid-content">{{ customer.email }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Mobile</div>
                        <div class="datagrid-content">{{ customer.mobile }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Sex</div>
                        <div class="datagrid-content">{{ customer.sex }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Birthdate</div>
                        <div class="datagrid-content">{{ customer.birthdate }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Nationality</div>
                        <div class="datagrid-content">{{ customer.national?.name }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Status</div>
                        <div class="datagrid-content">
                            <span class="badge" :class="displayStatus(customer.status).bgClass">
                                {{ displayStatus(customer.status).label }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Email Verified</div>
                        <div class="datagrid-content">
                            <span class="badge bg-success-lt" v-if="customer.email_verified_at">
                                Verified
                            </span>
                            <span class="badge bg-danger-lt" v-if="!customer.email_verified_at">
                                Not Verified
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Mobile Verified</div>
                        <div class="datagrid-content">
                            <span class="badge bg-success-lt" v-if="customer.mobile_verified_at">
                                Verified
                            </span>
                            <span class="badge bg-danger-lt" v-if="!customer.mobile_verified_at">
                                Not Verified
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineProps} from "vue"
import {IconArrowLeft} from "@tabler/icons-vue";
import {useEnum} from "../../../Composables/useEnum.js";


const props = defineProps({
    customer: Object,
    statuses: Array,
})

const {display: displayStatus} = useEnum(props.statuses)

</script>
