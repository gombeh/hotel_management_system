<template>
    <div class="card shadow-lg text-center p-4" style="max-width: 450px; margin: 5rem auto; border-top: 5px solid #dc3545;">
        <div class="mb-3">
            <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
        </div>
        <h3 class="text-danger mb-3">Payment Failed</h3>
        <p class="text-muted mb-4">
            Unfortunately, your payment could not be processed. Please check your card details or try again later.
        </p>
        <div class="d-grid gap-2">
            <Link :href="route('bookings.payments.create', booking.id)" class="btn btn-outline-danger">
                Try Again
            </Link>
            <Link :href="route('home')" class="btn btn-secondary ">
                Back to Home
            </Link>
        </div>
    </div>
</template>

<script setup>
defineProps({
    booking: Object
})
</script>
