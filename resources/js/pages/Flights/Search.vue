<!-- eslint-disable vue/block-lang -->
<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AeroLayout from '@/layouts/AeroLayout.vue'; // Menggunakan huruf 'l' kecil untuk folder

// MATIKAN LAYOUT GLOBAL BAWAAN BREEZE
defineOptions({
    // @ts-expect-error - Inertia layout typing not recognized
    layout: null,
});

const props = defineProps({
    flights: { type: Array, default: () => [] },
    filters: {
        type: Object,
        default: () => ({ origin: '', destination: '', date: '' }),
    },
});

const searchForm = ref({
    origin: props.filters?.origin || '',
    destination: props.filters?.destination || '',
    date: props.filters?.date || '',
});

const submitSearch = () => {
    router.get('/flights', searchForm.value, {
        preserveState: true,
        replace: true,
    });
};

const formatTime = (dateString) => {
    return new Date(dateString).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="Search Flights" />

    <AeroLayout>
        <main
            class="mx-auto min-h-[80vh] max-w-5xl px-4 pt-24 pb-12 sm:px-6 lg:px-8"
        >
            <div
                class="mb-10 rounded-2xl border border-border bg-card p-6 text-left shadow-sm sm:p-8"
            >
                <h2 class="mb-6 text-xl font-bold text-foreground">
                    Find Your Next Flight
                </h2>
                <form
                    @submit.prevent="submitSearch"
                    class="flex flex-col gap-4 md:flex-row"
                >
                    <div class="flex-1">
                        <label
                            class="mb-1.5 block text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >Origin</label
                        >
                        <input
                            type="text"
                            v-model="searchForm.origin"
                            placeholder="e.g., CGK"
                            maxlength="3"
                            class="aero-input w-full rounded-lg border border-border bg-background px-4 py-2.5 text-sm font-semibold text-foreground uppercase placeholder:font-normal placeholder:text-muted-foreground"
                        />
                    </div>
                    <div class="flex-1">
                        <label
                            class="mb-1.5 block text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >Destination</label
                        >
                        <input
                            type="text"
                            v-model="searchForm.destination"
                            placeholder="e.g., JFK"
                            maxlength="3"
                            class="aero-input w-full rounded-lg border border-border bg-background px-4 py-2.5 text-sm font-semibold text-foreground uppercase placeholder:font-normal placeholder:text-muted-foreground"
                        />
                    </div>
                    <div class="flex-1">
                        <label
                            class="mb-1.5 block text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >Departure Date</label
                        >
                        <input
                            type="date"
                            v-model="searchForm.date"
                            class="aero-input w-full rounded-lg border border-border bg-background px-4 py-2.5 text-sm font-semibold text-foreground"
                        />
                    </div>
                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="hover:bg-primary-hover flex h-[42px] w-full items-center justify-center gap-2 rounded-lg bg-primary px-8 py-2.5 text-sm font-bold text-primary-foreground shadow-sm transition md:w-auto"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div
                    v-if="flights.length === 0"
                    class="rounded-2xl border border-border bg-card py-20 text-center shadow-sm"
                >
                    <div class="mb-4 text-5xl opacity-40">✈️</div>
                    <h3 class="mb-2 text-lg font-bold text-foreground">
                        No Flights Found
                    </h3>
                    <p class="font-medium text-muted-foreground">
                        We couldn't find any flights for this route or date. Try
                        adjusting your search.
                    </p>
                </div>

                <div
                    v-for="flight in flights"
                    :key="flight.id"
                    class="group relative flex flex-col overflow-hidden rounded-2xl border border-border bg-card shadow-sm transition-all hover:border-primary/40 hover:shadow-md md:flex-row"
                >
                    <div
                        class="flex flex-col items-center justify-center border-b border-border bg-muted/10 p-6 md:w-48 md:border-r md:border-b-0"
                    >
                        <span
                            class="inline-block rounded-md border border-primary/20 bg-primary/10 px-3 py-1 text-xs font-bold tracking-widest text-primary uppercase"
                        >
                            {{ flight.airline_code }}
                        </span>
                        <p class="mt-2 text-sm font-bold text-foreground">
                            {{ flight.flight_number }}
                        </p>
                    </div>

                    <div class="flex flex-1 flex-col justify-center p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div class="text-center sm:text-left">
                                <p class="text-2xl font-black text-foreground">
                                    {{ flight.origin_airport }}
                                </p>
                                <p
                                    class="mt-1 text-sm font-semibold text-muted-foreground"
                                >
                                    {{ formatTime(flight.departure_at) }}
                                </p>
                            </div>

                            <div
                                class="flex flex-1 flex-col items-center px-2 sm:px-4"
                            >
                                <span
                                    class="mb-2 text-[10px] font-bold tracking-widest text-muted-foreground uppercase"
                                    >Direct</span
                                >
                                <div
                                    class="relative flex w-full items-center justify-center"
                                >
                                    <div
                                        class="h-[2px] w-full bg-border transition-colors group-hover:bg-primary/30"
                                    ></div>
                                    <svg
                                        class="absolute h-5 w-5 bg-card px-0.5 text-muted-foreground transition-colors group-hover:text-primary"
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
                            </div>

                            <div class="text-center sm:text-right">
                                <p class="text-2xl font-black text-foreground">
                                    {{ flight.destination_airport }}
                                </p>
                                <p
                                    class="mt-1 text-sm font-semibold text-muted-foreground"
                                >
                                    {{ formatTime(flight.arrival_at) }}
                                </p>
                            </div>
                        </div>
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
                        class="flex flex-col items-center justify-center gap-3 bg-muted/10 p-6 md:w-56"
                    >
                        <p
                            class="text-[10px] font-bold tracking-wider text-muted-foreground uppercase"
                        >
                            Start from
                        </p>
                        <p class="mb-1 text-3xl font-black text-primary">
                            {{
                                new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'USD',
                                }).format(flight.base_price_usd)
                            }}
                        </p>
                        <button
                            @click="router.get(`/flights/${flight.id}/seats`)"
                            class="hover:bg-primary-hover w-full rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-primary-foreground shadow-sm transition"
                        >
                            Select Flight
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </AeroLayout>
</template>
