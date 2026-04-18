<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

const props = defineProps<{
    flight: any;
    selectedSeats: any[];
}>();

// Kita bikin struktur form dinamis pakai useForm Inertia
// Looping otomatis sebanyak jumlah kursi yang dibawa dari halaman sebelumnya
const form = useForm({
    passengers: props.selectedSeats.map((seat) => ({
        seat_id: seat.id,
        seat_code: seat.seat_code,
        first_name: '',
        last_name: '',
        passport_number: '',
    })),
});

// Hitung total harga buat ditampilin di struk kanan
const totalPrice = computed(() => {
    const baseTotal = props.flight.base_price_usd * props.selectedSeats.length;
    const additionalTotal = props.selectedSeats.reduce(
        (sum, seat) => sum + Number(seat.additional_price_usd),
        0,
    );

    return baseTotal + additionalTotal;
});

// Submit form ke tahap selanjutnya (Database & Stripe)
const submitCheckout = () => {
    // Rute ini belum kita bikin, nanti ini buat masukin ke DB
    form.post(`/flights/${props.flight.id}/checkout`);
};
</script>

<template>
    <Head title="Passenger Details" />

    <div class="min-h-screen bg-gray-50 py-12 dark:bg-gray-900">
        <div
            class="mx-auto flex max-w-5xl flex-col gap-8 px-4 sm:px-6 md:flex-row lg:px-8"
        >
            <div class="flex-1 space-y-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Passenger Details
                </h2>
                <p class="mb-4 text-sm text-gray-500">
                    Please enter the details exactly as they appear on your
                    passport/ID.
                </p>

                <form @submit.prevent="submitCheckout" class="space-y-6">
                    <div
                        v-for="(passenger, index) in form.passengers"
                        :key="passenger.seat_id"
                        class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800"
                    >
                        <div
                            class="mb-4 flex items-center justify-between border-b pb-4 dark:border-gray-700"
                        >
                            <h3
                                class="text-lg font-bold text-gray-800 dark:text-gray-100"
                            >
                                Passenger {{ index + 1 }}
                            </h3>
                            <span
                                class="rounded bg-blue-100 px-3 py-1 text-sm font-bold text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                            >
                                Seat: {{ passenger.seat_code }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-600 dark:text-gray-400"
                                    >First Name
                                    <span class="text-red-500">*</span></label
                                >
                                <Input
                                    v-model="passenger.first_name"
                                    required
                                    placeholder="e.g. Naufal"
                                />
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-600 dark:text-gray-400"
                                    >Last Name
                                    <span class="text-red-500">*</span></label
                                >
                                <Input
                                    v-model="passenger.last_name"
                                    required
                                    placeholder="e.g. Fathi"
                                />
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-600 dark:text-gray-400"
                                    >Passport / ID Number</label
                                >
                                <Input
                                    v-model="passenger.passport_number"
                                    placeholder="Optional for domestic, required for international"
                                />
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div
                class="sticky top-6 h-fit w-full rounded-xl border border-gray-100 bg-white p-6 shadow-sm md:w-80 dark:border-gray-700 dark:bg-gray-800"
            >
                <h3
                    class="mb-4 text-lg font-bold text-gray-800 dark:text-white"
                >
                    Booking Summary
                </h3>

                <div
                    class="mb-4 flex flex-col gap-2 border-b pb-4 text-sm text-gray-600 dark:border-gray-700 dark:text-gray-400"
                >
                    <div class="flex justify-between">
                        <span>Flight</span>
                        <span
                            class="font-semibold text-gray-900 dark:text-gray-100"
                            >{{ flight.flight_number }}</span
                        >
                    </div>
                    <div class="flex justify-between">
                        <span>Route</span>
                        <span
                            >{{ flight.origin_airport }} -
                            {{ flight.destination_airport }}</span
                        >
                    </div>
                    <div class="flex justify-between">
                        <span>Ticket (x{{ selectedSeats.length }})</span>
                        <span
                            >${{
                                flight.base_price_usd * selectedSeats.length
                            }}</span
                        >
                    </div>
                </div>

                <div class="mb-6 flex items-end justify-between">
                    <span class="font-medium text-gray-600">Total Price</span>
                    <span
                        class="text-3xl font-bold text-blue-600 dark:text-blue-400"
                        >${{ totalPrice }}</span
                    >
                </div>

                <Button
                    @click="submitCheckout"
                    class="w-full"
                    size="lg"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Processing...</span>
                    <span v-else>Pay with Stripe</span>
                </Button>

                <p class="mt-4 text-center text-xs text-gray-400">
                    By clicking pay, you agree to our Terms & Conditions.
                </p>
            </div>
        </div>
    </div>
</template>
