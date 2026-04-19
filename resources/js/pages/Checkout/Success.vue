<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import AeroLayout from '@/layouts/AeroLayout.vue';

// MATIKAN LAYOUT GLOBAL BAWAAN BREEZE
defineOptions({
    // @ts-expect-error - Inertia layout typing not recognized
    layout: null,
});

const { booking } = defineProps<{
    booking: any;
}>();
</script>

<template>
    <Head title="Payment Successful" />

    <AeroLayout>
        <main
            class="flex min-h-[80vh] items-center justify-center px-4 pt-24 pb-12 sm:px-6 lg:px-8"
        >
            <div
                class="w-full max-w-md overflow-hidden rounded-2xl border border-border bg-card shadow-xl"
            >
                <div class="bg-emerald-500 p-6 text-center">
                    <div
                        class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100"
                    >
                        <svg
                            class="h-10 w-10 text-emerald-600"
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
                    <p class="mt-1 text-emerald-50">
                        Your flight is confirmed.
                    </p>
                </div>

                <div class="p-6">
                    <div class="mb-8 text-center">
                        <p
                            class="mb-1 text-sm tracking-wider text-muted-foreground uppercase"
                        >
                            Booking Reference (PNR)
                        </p>
                        <p
                            class="font-mono text-4xl font-bold tracking-[0.2em] text-foreground"
                        >
                            {{ booking.pnr_code }}
                        </p>
                    </div>

                    <div
                        class="mb-6 space-y-3 border-y border-border py-4 text-sm"
                    >
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Flight</span>
                            <span class="font-semibold text-foreground">
                                {{ booking.flight.flight_number }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Route</span>
                            <span class="font-semibold text-foreground">
                                {{ booking.flight.origin_airport }} →
                                {{ booking.flight.destination_airport }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted-foreground"
                                >Total Paid</span
                            >
                            <span class="font-semibold text-primary">
                                {{
                                    new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'USD',
                                    }).format(booking.total_amount_usd)
                                }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a
                            :href="`/bookings/${booking.id}/ticket`"
                            class="block w-full"
                        >
                            <Button
                                class="hover:bg-primary-hover flex w-full items-center justify-center gap-2 bg-primary text-primary-foreground shadow-sm"
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
                            <Button
                                class="w-full border-border text-foreground hover:bg-muted"
                                variant="outline"
                                size="lg"
                            >
                                Go to History
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>
        </main>
    </AeroLayout>
</template>
