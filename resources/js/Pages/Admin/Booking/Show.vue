<template>
    <Head title="show booking"/>
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title text-capitalize">{{ booking.full_name }} Customer</h2>
        </div>
        <div class="col-auto ms-auto">
            <Link class="btn btn-1" :href="route('admin.bookings.index')">
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
                        <div class="datagrid-title">Ref Number</div>
                        <div class="datagrid-content">{{ booking.ref_number }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Full Name</div>
                        <div class="datagrid-content">
                            <Link :href="route('admin.customers.show', booking.customer.id)">
                                {{ booking.customer.full_name }}
                            </Link>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Adults</div>
                        <div class="datagrid-content">{{ booking.adults }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Children</div>
                        <div class="datagrid-content">{{ booking.children ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Check In</div>
                        <div class="datagrid-content">{{ booking.check_in }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Check Out</div>
                        <div class="datagrid-content">{{ booking.check_out }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Meal Plan</div>
                        <div class="datagrid-content">{{ booking.mealPlan.name }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Status</div>
                        <div class="datagrid-content">
                            <span class="badge" :class="displayStatus(booking.status).bgClass">
                                {{ displayStatus(booking.status).label }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Smoking Preference</div>
                        <div class="datagrid-content">
                            <span class="badge" :class="displaySmoking(booking.smoking_preference).bgClass">
                                {{ displaySmoking(booking.smoking_preference).label }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Total Price</div>
                        <div class="datagrid-content">
                            {{ booking.total_price}}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Partial Amount</div>
                        <div class="datagrid-content">
                            {{ booking.partial_amount}}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Created At</div>
                        <div class="datagrid-content">{{ booking.created_at }}</div>
                    </div>
                </div>
                <div class="datagrid mt-4">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Special Requests</div>
                        <div class="datagrid-content">
                            {{ booking.special_requests ?? '-'}}
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
    booking: Object,
    statuses: Array,
    smokingPreferences: Array,
})

const {display: displayStatus} = useEnum(props.statuses)

const {
    display: displaySmoking
} = useEnum(props.smokingPreferences)

</script>
