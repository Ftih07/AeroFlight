<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import AeroLayout from '@/layouts/AeroLayout.vue';

// MATIKAN LAYOUT GLOBAL BAWAAN BREEZE
defineOptions({
    // @ts-expect-error - Inertia layout typing not recognized
    layout: null,
});

const props = defineProps<{
    flight: any;
    groupedSeats: Record<string, any[]>;
}>();

// Menyimpan ID kursi yang dipilih user
const selectedSeats = ref<any[]>([]);

// Fungsi ketika kursi diklik
const toggleSeat = (seat: any) => {
    if (!seat.is_available) {
        return; // Kalau udah dipesan orang, abaikan
    }

    const index = selectedSeats.value.findIndex((s) => s.id === seat.id);

    if (index === -1) {
        selectedSeats.value.push(seat);
    } else {
        selectedSeats.value.splice(index, 1);
    }
};

// Hitung total harga otomatis
const totalPrice = computed(() => {
    const baseTotal = props.flight.base_price_usd * selectedSeats.value.length;

    const additionalTotal = selectedSeats.value.reduce(
        (sum, seat) => sum + Number(seat.additional_price_usd),
        0,
    );

    return baseTotal + additionalTotal;
});

// Lanjut ke halaman pembayaran
const proceedToBooking = () => {
    router.post(`/flights/${props.flight.id}/book`, {
        seat_ids: selectedSeats.value.map((s) => s.id),
    });
};
</script>

<template>
    <Head title="Select Seats" />

    <AeroLayout>
        <main
            class="mx-auto min-h-[80vh] max-w-6xl px-4 pt-24 pb-12 sm:px-6 lg:px-8"
        >
            <div class="flex flex-col gap-8 md:flex-row">
                <div
                    class="flex-1 rounded-2xl border border-border bg-card p-6 text-center shadow-sm sm:p-10"
                >
                    <h2 class="mb-2 text-2xl font-bold text-foreground">
                        Select Your Seats
                    </h2>
                    <p class="mb-10 text-sm text-muted-foreground">
                        Front seats offer extra legroom.
                    </p>

                    <div class="relative mx-auto inline-block">
                        <div
                            class="mx-auto mb-[-20px] h-24 w-3/4 rounded-t-[100px] border-4 border-b-0 border-border bg-muted/20"
                        ></div>

                        <div
                            class="relative rounded-[40px] border-4 border-border bg-muted/20 px-4 py-10 sm:px-12 sm:py-14"
                        >
                            <div
                                v-for="(seatsInRow, rowNumber) in groupedSeats"
                                :key="rowNumber"
                                class="mb-5 flex items-center justify-center gap-2 sm:gap-3"
                            >
                                <template
                                    v-for="(seat, index) in seatsInRow"
                                    :key="seat.id"
                                >
                                    <div
                                        v-if="
                                            index ===
                                            Math.ceil(seatsInRow.length / 2)
                                        "
                                        class="flex w-10 justify-center text-xs font-bold text-muted-foreground"
                                    >
                                        {{ rowNumber }}
                                    </div>

                                    <button
                                        @click="toggleSeat(seat)"
                                        :disabled="!seat.is_available"
                                        :class="[
                                            'group relative flex h-12 w-10 flex-col items-center justify-start rounded-t-xl rounded-b-md border-2 transition-all duration-200 sm:h-14 sm:w-12',
                                            !seat.is_available
                                                ? 'cursor-not-allowed border-border bg-muted opacity-40' // Kursi penuh
                                                : selectedSeats.some(
                                                        (s) => s.id === seat.id,
                                                    )
                                                  ? '-translate-y-1 transform border-primary bg-primary shadow-lg shadow-primary/30' // Kursi terpilih
                                                  : 'cursor-pointer border-primary/20 bg-background hover:-translate-y-0.5 hover:border-primary hover:shadow-md', // Kursi tersedia
                                        ]"
                                    >
                                        <div
                                            class="mt-1 h-2.5 w-6 rounded-full transition-colors sm:mt-1.5 sm:h-3 sm:w-8"
                                            :class="
                                                selectedSeats.some(
                                                    (s) => s.id === seat.id,
                                                )
                                                    ? 'bg-background/20'
                                                    : 'bg-muted'
                                            "
                                        ></div>

                                        <span
                                            class="mt-auto mb-1.5 text-xs font-bold sm:mb-2 sm:text-sm"
                                            :class="[
                                                !seat.is_available
                                                    ? 'text-muted-foreground'
                                                    : selectedSeats.some(
                                                            (s) =>
                                                                s.id ===
                                                                seat.id,
                                                        )
                                                      ? 'text-primary-foreground'
                                                      : 'text-foreground group-hover:text-primary',
                                            ]"
                                        >
                                            {{
                                                seat.seat_code.replace(
                                                    /[0-9]/g,
                                                    '',
                                                )
                                            }}
                                        </span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-10 flex flex-wrap justify-center gap-6 text-sm font-medium text-muted-foreground"
                    >
                        <div class="flex items-center gap-2.5">
                            <div
                                class="h-5 w-5 rounded-md border-2 border-primary/20 bg-background"
                            ></div>
                            Available
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="h-5 w-5 rounded-md border-2 border-primary bg-primary shadow-sm"
                            ></div>
                            Selected
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="h-5 w-5 rounded-md border-2 border-border bg-muted opacity-40"
                            ></div>
                            Unavailable
                        </div>
                    </div>
                </div>

                <div
                    class="h-fit w-full rounded-2xl border border-border bg-card p-6 shadow-sm md:w-96"
                >
                    <h3 class="mb-6 text-lg font-bold text-foreground">
                        Flight Summary
                    </h3>

                    <div class="mb-6 rounded-xl bg-muted/30 p-4 text-sm">
                        <div class="mb-2 flex items-center justify-between">
                            <span class="font-bold text-foreground">{{
                                flight.origin_airport
                            }}</span>
                            <svg
                                class="h-4 w-4 text-muted-foreground"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                />
                            </svg>
                            <span class="font-bold text-foreground">{{
                                flight.destination_airport
                            }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between text-muted-foreground"
                        >
                            <span>Flight Number</span>
                            <span class="font-mono font-semibold">{{
                                flight.flight_number
                            }}</span>
                        </div>
                    </div>

                    <div
                        v-if="selectedSeats.length > 0"
                        class="animate-in border-t border-border pt-6 duration-300 fade-in slide-in-from-bottom-2"
                    >
                        <h4 class="mb-3 text-sm font-semibold text-foreground">
                            Selected Seats ({{ selectedSeats.length }})
                        </h4>
                        <div class="mb-6 flex flex-wrap gap-2">
                            <span
                                v-for="seat in selectedSeats"
                                :key="seat.id"
                                class="rounded-md border border-primary/20 bg-primary/10 px-3 py-1.5 text-xs font-bold text-primary transition-all hover:bg-primary hover:text-primary-foreground"
                            >
                                {{ seat.seat_code }}
                            </span>
                        </div>

                        <div class="mb-6 flex items-end justify-between">
                            <span
                                class="text-sm font-medium text-muted-foreground"
                                >Total Price</span
                            >
                            <span class="text-3xl font-black text-primary">
                                {{
                                    new Intl.NumberFormat('en-US', {
                                        style: 'currency',
                                        currency: 'USD',
                                    }).format(totalPrice)
                                }}
                            </span>
                        </div>

                        <Button
                            @click="proceedToBooking"
                            class="hover:bg-primary-hover w-full bg-primary text-primary-foreground shadow-md transition-all hover:shadow-lg"
                            size="lg"
                        >
                            Continue to Passenger Details
                        </Button>
                    </div>

                    <div
                        v-else
                        class="border-t border-border pt-6 text-center text-sm text-muted-foreground"
                    >
                        <div
                            class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-muted"
                        >
                            <svg
                                class="h-6 w-6 opacity-50"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                />
                            </svg>
                        </div>
                        Please select at least one seat to continue.
                    </div>
                </div>
            </div>
        </main>
    </AeroLayout>
</template>
