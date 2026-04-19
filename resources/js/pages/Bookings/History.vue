<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import AeroLayout from '@/layouts/AeroLayout.vue';

// MATIKAN LAYOUT GLOBAL BAWAAN BREEZE
defineOptions({
    // @ts-expect-error - Inertia layout typing not recognized
    layout: null,
});

defineProps<{
    bookings: any[];
}>();

// State untuk Modal Refund
const showRefundModal = ref(false);
const bookingToRefund = ref<number | null>(null);

// Buka Modal
const openRefundModal = (id: number) => {
    bookingToRefund.value = id;
    showRefundModal.value = true;
};

// Tutup Modal
const closeRefundModal = () => {
    showRefundModal.value = false;
    setTimeout(() => {
        bookingToRefund.value = null;
    }, 200); // Tunggu animasi selesai baru reset ID
};

// Eksekusi Refund
const confirmRefund = () => {
    if (bookingToRefund.value !== null) {
        router.post(
            `/bookings/${bookingToRefund.value}/refund`,
            {},
            {
                preserveScroll: true,
                onSuccess: () => closeRefundModal(),
            },
        );
    }
};
</script>

<template>
    <Head title="My Bookings" />

    <AeroLayout>
        <main class="min-h-[80vh] px-4 pt-24 pb-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-foreground">
                        My Bookings
                    </h2>
                    <span
                        class="rounded-full border border-border bg-muted px-3 py-1 text-xs font-semibold text-muted-foreground"
                    >
                        {{ bookings.length }} Trips
                    </span>
                </div>

                <div
                    v-if="bookings.length === 0"
                    class="rounded-2xl border border-border bg-card py-20 text-center shadow-sm"
                >
                    <div class="mb-4 text-5xl opacity-40">🎫</div>
                    <h3 class="mb-2 text-lg font-bold text-foreground">
                        No Bookings Found
                    </h3>
                    <p class="text-sm text-muted-foreground">
                        You haven't booked any flights yet. Start exploring the
                        world with AeroFlight!
                    </p>
                    <a href="/#routes" class="mt-6 inline-block">
                        <Button
                            class="hover:bg-primary-hover bg-primary text-primary-foreground"
                            >Explore Flights</Button
                        >
                    </a>
                </div>

                <div class="space-y-6">
                    <div
                        v-for="booking in bookings"
                        :key="booking.id"
                        class="group relative flex flex-col overflow-hidden rounded-2xl border border-border bg-card shadow-sm transition-all hover:border-primary/40 hover:shadow-md md:flex-row"
                    >
                        <div class="flex-1 p-6">
                            <div class="mb-6 flex items-center justify-between">
                                <span
                                    class="rounded-md bg-muted px-2.5 py-1 font-mono text-xs font-bold tracking-widest text-muted-foreground"
                                >
                                    PNR:
                                    <span class="text-foreground">{{
                                        booking.pnr_code || 'PENDING'
                                    }}</span>
                                </span>

                                <span
                                    v-if="booking.status === 'paid'"
                                    class="rounded-full bg-emerald-500/15 px-3 py-1 text-[10px] font-extrabold tracking-wider text-emerald-600 uppercase dark:text-emerald-400"
                                >
                                    Confirmed
                                </span>
                                <span
                                    v-else-if="booking.status === 'used'"
                                    class="rounded-full bg-muted px-3 py-1 text-[10px] font-extrabold tracking-wider text-muted-foreground uppercase"
                                >
                                    Flown
                                </span>
                                <span
                                    v-else-if="
                                        booking.status === 'refund_requested'
                                    "
                                    class="rounded-full bg-amber-500/15 px-3 py-1 text-[10px] font-extrabold tracking-wider text-amber-600 uppercase dark:text-amber-400"
                                >
                                    Refund Pending
                                </span>
                                <span
                                    v-else-if="
                                        ['refunded', 'cancelled'].includes(
                                            booking.status,
                                        )
                                    "
                                    class="rounded-full bg-destructive/15 px-3 py-1 text-[10px] font-extrabold tracking-wider text-destructive uppercase dark:text-red-400"
                                >
                                    {{ booking.status }}
                                </span>
                                <span
                                    v-else
                                    class="rounded-full bg-primary/15 px-3 py-1 text-[10px] font-extrabold tracking-wider text-primary uppercase dark:text-blue-400"
                                >
                                    Awaiting Payment
                                </span>
                            </div>

                            <div
                                class="flex items-center justify-between gap-4"
                            >
                                <div class="text-center sm:text-left">
                                    <p
                                        class="text-2xl font-black text-foreground"
                                    >
                                        {{ booking.flight.origin_airport }}
                                    </p>
                                    <p
                                        class="text-xs font-semibold text-muted-foreground"
                                    >
                                        Origin
                                    </p>
                                </div>

                                <div
                                    class="flex flex-1 flex-col items-center px-4"
                                >
                                    <span
                                        class="mb-1 text-[10px] font-bold tracking-widest text-muted-foreground uppercase"
                                        >Direct</span
                                    >
                                    <div
                                        class="relative flex w-full items-center justify-center"
                                    >
                                        <div
                                            class="h-[2px] w-full bg-border"
                                        ></div>
                                        <svg
                                            class="absolute h-5 w-5 bg-card px-0.5 text-primary"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                            />
                                        </svg>
                                    </div>
                                    <p
                                        class="mt-2 text-xs font-semibold text-foreground"
                                    >
                                        {{ booking.flight.flight_number }}
                                    </p>
                                </div>

                                <div class="text-center sm:text-right">
                                    <p
                                        class="text-2xl font-black text-foreground"
                                    >
                                        {{ booking.flight.destination_airport }}
                                    </p>
                                    <p
                                        class="text-xs font-semibold text-muted-foreground"
                                    >
                                        Destination
                                    </p>
                                </div>
                            </div>

                            <div
                                class="mt-6 flex flex-wrap gap-y-4 rounded-lg bg-muted/30 p-4"
                            >
                                <div class="w-1/2 sm:w-1/3">
                                    <p
                                        class="text-[10px] font-bold text-muted-foreground uppercase"
                                    >
                                        Departure Date
                                    </p>
                                    <p
                                        class="text-sm font-semibold text-foreground"
                                    >
                                        {{
                                            new Date(
                                                booking.flight.departure_at,
                                            ).toLocaleDateString()
                                        }}
                                    </p>
                                </div>
                                <div class="w-1/2 sm:w-1/3">
                                    <p
                                        class="text-[10px] font-bold text-muted-foreground uppercase"
                                    >
                                        Time
                                    </p>
                                    <p
                                        class="text-sm font-semibold text-foreground"
                                    >
                                        {{
                                            new Date(
                                                booking.flight.departure_at,
                                            ).toLocaleTimeString([], {
                                                hour: '2-digit',
                                                minute: '2-digit',
                                            })
                                        }}
                                    </p>
                                </div>
                                <div class="w-full sm:w-1/3 sm:text-right">
                                    <p
                                        class="text-[10px] font-bold text-muted-foreground uppercase"
                                    >
                                        Total Amount
                                    </p>
                                    <p class="text-sm font-black text-primary">
                                        {{
                                            new Intl.NumberFormat('en-US', {
                                                style: 'currency',
                                                currency: 'USD',
                                            }).format(booking.total_amount_usd)
                                        }}
                                    </p>
                                </div>
                            </div>

                            <p
                                v-if="booking.status === 'refunded'"
                                class="mt-3 flex items-center gap-1 text-xs font-bold text-destructive"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Refunded Amount: ${{
                                    booking.transactions?.find(
                                        (t: any) => t.type === 'refund',
                                    )?.amount || '0.00'
                                }}
                            </p>
                        </div>

                        <div
                            class="relative hidden w-0 flex-col items-center justify-center border-l-2 border-dashed border-border md:flex"
                        >
                            <div
                                class="absolute -top-3 h-6 w-6 rounded-full border-b border-border bg-background"
                            ></div>
                            <div
                                class="absolute -bottom-3 h-6 w-6 rounded-full border-t border-border bg-background"
                            ></div>
                        </div>
                        <div
                            class="relative flex h-0 w-full items-center justify-center border-t-2 border-dashed border-border md:hidden"
                        >
                            <div
                                class="absolute -left-3 h-6 w-6 rounded-full border-r border-border bg-background"
                            ></div>
                            <div
                                class="absolute -right-3 h-6 w-6 rounded-full border-l border-border bg-background"
                            ></div>
                        </div>

                        <div
                            class="flex flex-col justify-center gap-3 bg-muted/10 p-6 md:w-56"
                        >
                            <a
                                v-if="['paid', 'used'].includes(booking.status)"
                                :href="`/bookings/${booking.id}/ticket`"
                                class="w-full"
                            >
                                <Button
                                    class="hover:bg-primary-hover w-full bg-primary text-primary-foreground shadow-sm"
                                >
                                    Download E-Ticket
                                </Button>
                            </a>

                            <Button
                                v-if="booking.status === 'paid'"
                                variant="outline"
                                class="w-full border-destructive/50 text-destructive hover:bg-destructive/10 hover:text-destructive"
                                @click="openRefundModal(booking.id)"
                            >
                                Request Refund
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <transition name="modal">
            <div
                v-if="showRefundModal"
                class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            >
                <div
                    class="absolute inset-0 bg-background/80 backdrop-blur-sm transition-opacity"
                    @click="closeRefundModal"
                ></div>

                <div
                    class="relative z-10 w-full max-w-md transform overflow-hidden rounded-2xl border border-border bg-card p-6 text-left shadow-2xl transition-all"
                >
                    <div
                        class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-destructive/10"
                    >
                        <svg
                            class="h-7 w-7 text-destructive"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                            />
                        </svg>
                    </div>

                    <h3
                        class="mb-2 text-center text-lg font-bold text-foreground"
                    >
                        Confirm Refund Request
                    </h3>

                    <p class="mb-6 text-center text-sm text-muted-foreground">
                        Are you sure you want to cancel this booking and request
                        a refund? Your seat will be released and this action
                        <span class="font-bold text-foreground"
                            >cannot be undone</span
                        >.
                    </p>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row">
                        <button
                            @click="closeRefundModal"
                            class="w-full rounded-md border border-border bg-background px-4 py-2 text-sm font-semibold text-foreground transition-colors hover:bg-muted"
                        >
                            Cancel
                        </button>
                        <button
                            @click="confirmRefund"
                            class="w-full rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700"
                        >
                            Yes, Refund
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </AeroLayout>
</template>

<style scoped>
/* Transisi untuk Modal */
.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-from .relative,
.modal-leave-to .relative {
    transform: scale(0.95) translateY(10px);
    opacity: 0;
}
</style>
