<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    flight: any;
    groupedSeats: Record<string, any[]>;
}>();

// Menyimpan ID kursi yang dipilih user
const selectedSeats = ref<any[]>([]);

// Fungsi ketika kursi diklik
const toggleSeat = (seat: any) => {
    if (!seat.is_available) {
        return; // Kalau udah dipesan orang, abaikan (sudah pakai kurung kurawal)
    }

    const index = selectedSeats.value.findIndex((s) => s.id === seat.id);

    // Tambah baris kosong di atas ini agar linter senang
    if (index === -1) {
        // Kalau belum ada, tambahkan
        selectedSeats.value.push(seat);
    } else {
        // Kalau sudah ada (diklik lagi), hapus dari pilihan
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

    // Tambah baris kosong di atas return ini agar linter senang
    return baseTotal + additionalTotal;
});

// Lanjut ke halaman pembayaran (Nanti kita bikin form Passenger-nya)
const proceedToBooking = () => {
    // Kita lempar array ID kursi yang dipilih ke halaman berikutnya
    router.post(`/flights/${props.flight.id}/book`, {
        seat_ids: selectedSeats.value.map((s) => s.id),
    });
};
</script>

<template>
    <Head title="Select Seats" />

    <div class="min-h-screen bg-gray-50 py-12 dark:bg-gray-900">
        <div
            class="mx-auto flex max-w-5xl flex-col gap-8 px-4 sm:px-6 md:flex-row lg:px-8"
        >
            <div
                class="flex-1 rounded-xl bg-white p-6 text-center shadow-sm dark:bg-gray-800"
            >
                <h2
                    class="mb-6 text-xl font-bold text-gray-800 dark:text-white"
                >
                    Select Your Seats
                </h2>

                <div
                    class="inline-block rounded-[3rem] border-4 border-gray-200 bg-gray-100 p-8 dark:border-gray-600 dark:bg-gray-700"
                >
                    <div
                        v-for="(seatsInRow, rowNumber) in groupedSeats"
                        :key="rowNumber"
                        class="mb-4 flex items-center justify-center gap-2"
                    >
                        <template
                            v-for="(seat, index) in seatsInRow"
                            :key="seat.id"
                        >
                            <div
                                v-if="
                                    index === Math.ceil(seatsInRow.length / 2)
                                "
                                class="flex w-8 justify-center text-sm font-bold text-gray-400"
                            >
                                {{ rowNumber }}
                            </div>

                            <button
                                @click="toggleSeat(seat)"
                                :disabled="!seat.is_available"
                                :class="[
                                    'flex h-12 w-12 items-center justify-center rounded-t-lg rounded-b-sm border-2 text-sm font-bold transition-all',
                                    !seat.is_available
                                        ? 'cursor-not-allowed border-gray-400 bg-gray-300 text-gray-500 opacity-50'
                                        : selectedSeats.some(
                                                (s) => s.id === seat.id,
                                            )
                                          ? '-translate-y-1 transform border-blue-700 bg-blue-600 text-white shadow-md'
                                          : 'border-blue-200 bg-white text-blue-800 hover:border-blue-400 hover:bg-blue-50',
                                ]"
                            >
                                {{ seat.seat_code.replace(/[0-9]/g, '') }}
                            </button>
                        </template>
                    </div>
                </div>

                <div
                    class="mt-8 flex justify-center gap-6 text-sm text-gray-600 dark:text-gray-300"
                >
                    <div class="flex items-center gap-2">
                        <div
                            class="h-4 w-4 rounded-sm border-2 border-blue-200 bg-white"
                        ></div>
                        Available
                    </div>
                    <div class="flex items-center gap-2">
                        <div
                            class="h-4 w-4 rounded-sm border-2 border-blue-700 bg-blue-600"
                        ></div>
                        Selected
                    </div>
                    <div class="flex items-center gap-2">
                        <div
                            class="h-4 w-4 rounded-sm border-2 border-gray-400 bg-gray-300"
                        ></div>
                        Unavailable
                    </div>
                </div>
            </div>

            <div
                class="h-fit w-full rounded-xl bg-white p-6 shadow-sm md:w-80 dark:bg-gray-800"
            >
                <h3 class="mb-4 font-bold text-gray-800 dark:text-white">
                    Flight Summary
                </h3>
                <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                    <p>
                        {{ flight.origin_airport }} →
                        {{ flight.destination_airport }}
                    </p>
                    <p>{{ flight.flight_number }}</p>
                </div>

                <div
                    v-if="selectedSeats.length > 0"
                    class="border-t pt-4 dark:border-gray-700"
                >
                    <h4
                        class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300"
                    >
                        Selected Seats:
                    </h4>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span
                            v-for="seat in selectedSeats"
                            :key="seat.id"
                            class="rounded bg-blue-100 px-2 py-1 text-xs font-bold text-blue-800"
                        >
                            {{ seat.seat_code }}
                        </span>
                    </div>

                    <div class="mb-6 flex items-end justify-between">
                        <span class="text-sm text-gray-500">Total Price</span>
                        <span class="text-2xl font-bold text-blue-600"
                            >${{ totalPrice }}</span
                        >
                    </div>

                    <Button @click="proceedToBooking" class="w-full" size="lg"
                        >Continue to Details</Button
                    >
                </div>

                <div
                    v-else
                    class="border-t pt-4 text-center text-sm text-gray-500 dark:border-gray-700"
                >
                    Please select at least one seat to continue.
                </div>
            </div>
        </div>
    </div>
</template>
