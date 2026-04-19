<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { loadStripe } from '@stripe/stripe-js';
import { ref, onMounted } from 'vue';
import { Button } from '@/components/ui/button';
import AeroLayout from '@/layouts/AeroLayout.vue';

defineOptions({
    // @ts-expect-error - Inertia layout typing not recognized
    layout: null,
});

const props = defineProps<{
    flight: any;
    booking: any;
    clientSecret: string;
    stripeKey: string;
}>();

const stripeElementRef = ref<HTMLElement | null>(null);
const isProcessing = ref(false);
const errorMessage = ref('');
let stripe: any = null;
let elements: any = null;

onMounted(async () => {
    // Inisialisasi Stripe JS
    stripe = await loadStripe(props.stripeKey);

    // KUSTOMISASI DESAIN STRIPE AGAR MATCH DENGAN AEROFLIGHT
    // Kita gunakan mode transparan agar mewarisi warna dari container bg-card kita
    const appearance = {
        theme: 'none',
        variables: {
            fontFamily: 'ui-sans-serif, system-ui, sans-serif',
            colorBackground: 'transparent',
            colorText: 'currentColor', // Ikut warna teks AeroFlight
            colorDanger: '#ef4444',
            borderRadius: '8px',
            spacingUnit: '4px',
            colorTextPlaceholder: '#9ca3af',
        },
        rules: {
            '.Input': {
                border: '1px solid #e5e7eb', // border-border light
                backgroundColor: 'transparent',
                padding: '12px 16px',
                fontSize: '14px',
                transition: 'border-color 0.15s, box-shadow 0.15s',
            },
            '.Input:focus': {
                borderColor: '#3b82f6', // primary biru
                boxShadow: '0 0 0 3px rgba(59, 130, 246, 0.15)',
                outline: 'none',
            },
            '.Label': {
                fontWeight: '500',
                fontSize: '14px',
                color: '#6b7280', // text-muted
                marginBottom: '6px',
            },
            // Deteksi Dark Mode (Kalau kamu punya toggle dark mode)
            '.Input--invalid': {
                borderColor: '#ef4444',
                color: '#ef4444',
            },
        },
    };

    elements = stripe.elements({
        clientSecret: props.clientSecret,
        appearance,
    });

    const paymentElement = elements.create('payment', {
        layout: 'tabs', // Layout modern dari Stripe (mirip accordion)
    });

    if (stripeElementRef.value) {
        paymentElement.mount(stripeElementRef.value);
    }
});

const submitPayment = async () => {
    if (!stripe || !elements) {
        return [];
    }

    isProcessing.value = true;
    errorMessage.value = '';

    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            // Redirect otomatis ke route success kita jika berhasil
            return_url: window.location.origin + '/checkout/success',
        },
    });

    // Kalau sampai baris ini, berarti ada error validasi kartu (ex: saldo kurang, nomor salah)
    if (error) {
        errorMessage.value = error.message;
        isProcessing.value = false;
    }
};
</script>

<template>
    <Head title="Secure Payment" />

    <AeroLayout>
        <main
            class="mx-auto min-h-[80vh] max-w-5xl px-4 pt-24 pb-12 sm:px-6 lg:px-8"
        >
            <div class="flex flex-col gap-8 md:flex-row">
                <div class="flex-1 space-y-6">
                    <h2 class="text-2xl font-bold text-foreground">
                        Complete Payment
                    </h2>
                    <p class="text-sm text-muted-foreground">
                        All transactions are secured and encrypted.
                    </p>

                    <div
                        class="rounded-xl border border-border bg-card p-6 shadow-sm"
                    >
                        <div ref="stripeElementRef" class="min-h-[250px]">
                            <div
                                v-if="!stripe"
                                class="flex h-40 items-center justify-center"
                            >
                                <div
                                    class="h-6 w-6 animate-spin rounded-full border-2 border-border border-t-primary"
                                ></div>
                            </div>
                        </div>

                        <div
                            v-if="errorMessage"
                            class="mt-4 rounded-lg bg-destructive/10 p-4 text-sm font-medium text-destructive"
                        >
                            {{ errorMessage }}
                        </div>
                    </div>
                </div>

                <div
                    class="sticky top-24 h-fit w-full rounded-xl border border-border bg-card p-6 shadow-sm md:w-80"
                >
                    <h3 class="mb-4 text-lg font-bold text-foreground">
                        Booking Summary
                    </h3>

                    <div
                        class="mb-4 flex flex-col gap-2 border-b border-border pb-4 text-sm text-muted-foreground"
                    >
                        <div class="flex justify-between">
                            <span>Booking ID</span>
                            <span
                                class="font-mono font-semibold text-foreground"
                            >
                                #{{ String(booking.id).padStart(5, '0') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Flight</span>
                            <span class="font-semibold text-foreground">
                                {{ flight.flight_number }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Passengers</span>
                            <span class="text-foreground">
                                {{ booking.passengers.length }} Person(s)
                            </span>
                        </div>
                    </div>

                    <div class="mb-6 flex items-end justify-between">
                        <span class="font-medium text-muted-foreground"
                            >Total to Pay</span
                        >
                        <span class="text-3xl font-bold text-primary">
                            ${{ booking.total_amount_usd }}
                        </span>
                    </div>

                    <Button
                        @click="submitPayment"
                        class="hover:bg-primary-hover w-full bg-primary text-primary-foreground shadow-sm"
                        size="lg"
                        :disabled="isProcessing"
                    >
                        <svg
                            v-if="isProcessing"
                            class="mr-2 h-4 w-4 animate-spin"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                            />
                        </svg>
                        <span v-if="isProcessing">Processing Payment...</span>
                        <span v-else>Pay ${{ booking.total_amount_usd }}</span>
                    </Button>
                </div>
            </div>
        </main>
    </AeroLayout>
</template>
