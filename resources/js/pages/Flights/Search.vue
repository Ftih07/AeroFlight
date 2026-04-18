<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

// Terima props dari Controller
const props = defineProps<{
    flights: Array<any>;
    filters: {
        origin?: string;
        destination?: string;
        date?: string;
    };
}>();

// State untuk form pencarian
const searchForm = ref({
    origin: props.filters.origin || '',
    destination: props.filters.destination || '',
    date: props.filters.date || '',
});

// Fungsi untuk submit pencarian
const submitSearch = () => {
    router.get('/flights', searchForm.value, {
        preserveState: true,
        replace: true,
    });
};
</script>

<template>
    <Head title="Search Flights" />

    <div class="min-h-screen bg-gray-50 py-12 dark:bg-gray-900">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div
                class="mb-8 rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800"
            >
                <h2
                    class="mb-4 text-xl font-bold text-gray-800 dark:text-white"
                >
                    Find Your Next Flight
                </h2>
                <form
                    @submit.prevent="submitSearch"
                    class="flex flex-col gap-4 md:flex-row"
                >
                    <div class="flex-1">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-500"
                            >Origin (IATA)</label
                        >
                        <Input
                            v-model="searchForm.origin"
                            placeholder="e.g., CGK"
                            maxlength="3"
                            class="uppercase"
                        />
                    </div>
                    <div class="flex-1">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-500"
                            >Destination (IATA)</label
                        >
                        <Input
                            v-model="searchForm.destination"
                            placeholder="e.g., JFK"
                            maxlength="3"
                            class="uppercase"
                        />
                    </div>
                    <div class="flex-1">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-500"
                            >Departure Date</label
                        >
                        <Input v-model="searchForm.date" type="date" />
                    </div>
                    <div class="flex items-end">
                        <Button type="submit" class="w-full md:w-auto"
                            >Search Flights</Button
                        >
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                <div
                    v-if="flights.length === 0"
                    class="rounded-xl bg-white py-12 text-center shadow-sm dark:bg-gray-800"
                >
                    <p class="text-gray-500">
                        No flights found for this route.
                    </p>
                </div>

                <div
                    v-for="flight in flights"
                    :key="flight.id"
                    class="flex flex-col items-center justify-between rounded-xl border border-gray-100 bg-white p-6 shadow-sm transition-shadow hover:shadow-md md:flex-row dark:border-gray-700 dark:bg-gray-800"
                >
                    <div class="mb-4 md:mb-0">
                        <span
                            class="inline-block rounded bg-blue-100 px-2 py-1 text-xs font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                        >
                            {{ flight.airline_code }}
                        </span>
                        <p
                            class="mt-1 font-semibold text-gray-900 dark:text-gray-100"
                        >
                            {{ flight.flight_number }}
                        </p>
                    </div>

                    <div class="flex items-center space-x-6 text-center">
                        <div>
                            <p
                                class="text-2xl font-bold text-gray-800 dark:text-white"
                            >
                                {{
                                    new Date(
                                        flight.departure_at,
                                    ).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                    })
                                }}
                            </p>
                            <p class="text-sm font-medium text-gray-500">
                                {{ flight.origin_airport }}
                            </p>
                        </div>

                        <div class="flex flex-col items-center px-4">
                            <span class="text-xs text-gray-400">Direct</span>
                            <div
                                class="my-1 h-[2px] w-16 bg-gray-300 dark:bg-gray-600"
                            ></div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-400"
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

                        <div>
                            <p
                                class="text-2xl font-bold text-gray-800 dark:text-white"
                            >
                                {{
                                    new Date(
                                        flight.arrival_at,
                                    ).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit',
                                    })
                                }}
                            </p>
                            <p class="text-sm font-medium text-gray-500">
                                {{ flight.destination_airport }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="mt-4 flex flex-col items-end border-t border-gray-100 pt-4 md:mt-0 md:border-t-0 md:border-l md:pt-0 md:pl-6 dark:border-gray-700"
                    >
                        <p class="text-sm text-gray-500">Start from</p>
                        <p
                            class="mb-2 text-2xl font-bold text-blue-600 dark:text-blue-400"
                        >
                            ${{ flight.base_price_usd }}
                        </p>
                        <Button
                            variant="default"
                            @click="router.get(`/flights/${flight.id}/seats`)"
                        >
                            Select
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
