<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const { booking } = defineProps<{
    booking: any;
}>();
</script>

<template>
    <Head title="Payment Successful" />

    <div
        class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8 dark:bg-gray-900"
    >
        <div
            class="w-full max-w-md overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-800"
        >
            <div class="bg-green-500 p-6 text-center">
                <div
                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100"
                >
                    <svg
                        class="h-10 w-10 text-green-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">
                    Payment Successful!
                </h2>
                <p class="mt-1 text-green-100">Your flight is confirmed.</p>
            </div>

            <div class="p-6">
                <div class="mb-8 text-center">
                    <p
                        class="mb-1 text-sm tracking-wider text-gray-500 uppercase dark:text-gray-400"
                    >
                        Booking Reference (PNR)
                    </p>
                    <p
                        class="font-mono text-4xl font-bold tracking-[0.2em] text-gray-900 dark:text-white"
                    >
                        {{ booking.pnr_code }}
                    </p>
                </div>

                <div
                    class="mb-6 space-y-3 border-t border-b border-gray-100 py-4 text-sm dark:border-gray-700"
                >
                    <div class="flex justify-between">
                        <span class="text-gray-500">Flight</span>
                        <span
                            class="font-semibold text-gray-800 dark:text-gray-200"
                            >{{ booking.flight.flight_number }}</span
                        >
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Route</span>
                        <span
                            class="font-semibold text-gray-800 dark:text-gray-200"
                            >{{ booking.flight.origin_airport }} →
                            {{ booking.flight.destination_airport }}</span
                        >
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total Paid</span>
                        <span
                            class="font-semibold text-blue-600 dark:text-blue-400"
                            >${{ booking.total_amount_usd }}</span
                        >
                    </div>
                </div>

                <div class="space-y-3">
                    <a
                        :href="`/bookings/${booking.id}/ticket`"
                        class="block w-full"
                    >
                        <Button
                            class="flex w-full items-center justify-center gap-2"
                            variant="default"
                            size="lg"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                                />
                            </svg>
                            Download E-Ticket
                        </Button>
                    </a>

                    <Link href="/my-bookings" class="block">
                        <Button class="w-full" variant="outline" size="lg">
                            Go to History
                        </Button>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
