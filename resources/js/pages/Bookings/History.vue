<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

defineProps<{
    bookings: any[];
}>();

const requestRefund = (id: number) => {
    if (confirm('Are you sure you want to request a refund for this ticket?')) {
        router.post(`/bookings/${id}/refund`, {}, { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="My Bookings" />

    <div
        class="min-h-screen bg-gray-50 px-4 py-12 sm:px-6 lg:px-8 dark:bg-gray-900"
    >
        <div class="mx-auto max-w-4xl space-y-6">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">
                My Bookings & History
            </h2>

            <div
                v-if="bookings.length === 0"
                class="rounded-xl bg-white py-12 text-center shadow-sm dark:bg-gray-800"
            >
                <p class="text-gray-500">You don't have any bookings yet.</p>
            </div>

            <div
                v-for="booking in bookings"
                :key="booking.id"
                class="flex flex-col items-center justify-between rounded-xl border border-gray-100 bg-white p-6 shadow-sm md:flex-row dark:border-gray-700 dark:bg-gray-800"
            >
                <div class="mb-4 w-full flex-1 md:mb-0">
                    <div class="mb-2 flex items-center gap-3">
                        <span class="text-sm font-bold text-gray-500"
                            >PNR: {{ booking.pnr_code || 'PENDING' }}</span
                        >
                        <span
                            v-if="booking.status === 'paid'"
                            class="rounded bg-green-100 px-2 py-1 text-xs font-bold text-green-700"
                            >PAID</span
                        >
                        <span
                            v-else-if="booking.status === 'used'"
                            class="rounded bg-gray-100 px-2 py-1 text-xs font-bold text-gray-700"
                            >USED</span
                        >
                        <span
                            v-else-if="booking.status === 'refund_requested'"
                            class="rounded bg-yellow-100 px-2 py-1 text-xs font-bold text-yellow-700"
                            >REFUND PENDING</span
                        >
                        <span
                            v-else-if="booking.status === 'refunded'"
                            class="rounded bg-red-100 px-2 py-1 text-xs font-bold text-red-700"
                            >REFUNDED</span
                        >
                        <span
                            v-else-if="booking.status === 'cancelled'"
                            class="rounded bg-red-100 px-2 py-1 text-xs font-bold text-red-700"
                            >CANCELLED</span
                        >
                        <span
                            v-else
                            class="rounded bg-orange-100 px-2 py-1 text-xs font-bold text-orange-700"
                            >PENDING</span
                        >
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ booking.flight.origin_airport }} →
                        {{ booking.flight.destination_airport }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{
                            new Date(
                                booking.flight.departure_at,
                            ).toLocaleString()
                        }}
                        | {{ booking.flight.flight_number }}
                    </p>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ booking.flight.origin_airport }} →
                        {{ booking.flight.destination_airport }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{
                            new Date(
                                booking.flight.departure_at,
                            ).toLocaleString()
                        }}
                        | {{ booking.flight.flight_number }}
                    </p>

                    <p
                        v-if="booking.status === 'refunded'"
                        class="mt-2 text-sm font-bold text-red-600"
                    >
                        Refunded: ${{
                            booking.transactions?.find(
                                (t) => t.type === 'refund',
                            )?.amount || '0.00'
                        }}
                    </p>
                </div>

                <div class="flex w-full gap-2 md:w-auto">
                    <a
                        v-if="['paid', 'used'].includes(booking.status)"
                        :href="`/bookings/${booking.id}/ticket`"
                    >
                        <Button variant="outline">Download PDF</Button>
                    </a>

                    <Button
                        v-if="booking.status === 'paid'"
                        variant="destructive"
                        @click="requestRefund(booking.id)"
                    >
                        Request Refund
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
