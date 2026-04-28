<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AeroLayout from '@/Layouts/AeroLayout.vue';

const isComingSoon = ref(false);

const showComingSoon = () => {
    isComingSoon.value = true;
    setTimeout(() => {
        isComingSoon.value = false;
    }, 3000);
};
</script>

<template>
    <Head title="Charter Aircraft - AeroFlight" />

    <AeroLayout>
        <div
            class="relative min-h-screen bg-background pb-20 text-muted-foreground transition-colors duration-300"
        >
            <transition
                enter-active-class="transition ease-out duration-300 transform"
                enter-from-class="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="opacity-100 translate-y-0 sm:translate-x-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="isComingSoon"
                    class="fixed top-24 right-4 z-50 flex w-full max-w-xs items-center space-x-3 rounded-lg border border-border bg-card p-4 text-foreground shadow-xl"
                    role="alert"
                >
                    <div
                        class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                    <div class="ml-3 text-sm font-medium">
                        Sistem reservasi Charter segera hadir!
                    </div>
                </div>
            </transition>

            <div
                class="relative overflow-hidden border-b border-border px-6 pt-24 pb-16 lg:px-8"
            >
                <div
                    class="absolute top-0 left-1/2 -z-10 h-full w-full -translate-x-1/2 overflow-hidden"
                >
                    <div
                        class="absolute -top-24 left-1/4 h-96 w-96 rounded-full bg-primary/20 blur-3xl"
                    ></div>
                </div>

                <div class="mx-auto max-w-4xl text-center">
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-sm font-medium text-primary"
                    >
                        🛩️ Private & Exclusive
                    </div>
                    <h1
                        class="mb-6 text-4xl font-extrabold tracking-tight text-foreground md:text-6xl"
                    >
                        Charter Aircraft
                    </h1>
                    <p
                        class="mx-auto max-w-3xl text-lg leading-relaxed text-muted-foreground md:text-xl"
                    >
                        From small propeller planes to large executive jets.
                        Enjoy absolute privacy, flexible schedules, and VIP
                        comfort on your own terms.
                    </p>

                    <button
                        @click="showComingSoon"
                        class="mt-8 inline-flex transform items-center gap-2 rounded-xl bg-primary px-6 py-3 font-semibold text-primary-foreground shadow-lg shadow-primary/20 transition-all duration-200 hover:-translate-y-1 hover:bg-primary/90"
                    >
                        View Fleet & Charter
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mx-auto mt-16 max-w-5xl px-6 lg:px-8">
                <div
                    class="mb-20 grid grid-cols-1 items-center gap-12 md:grid-cols-2"
                >
                    <div>
                        <h2 class="mb-4 text-3xl font-bold text-foreground">
                            Fly on Your Schedule
                        </h2>
                        <p class="mb-4 leading-relaxed text-muted-foreground">
                            Bypass the busy commercial terminals. Our charter
                            service lets you dictate the departure time,
                            destination, and the aircraft that fits your
                            specific mission.
                        </p>
                        <p class="leading-relaxed text-muted-foreground">
                            In our upcoming portal, you'll be able to browse
                            through detailed descriptions of our premium fleet,
                            select the specific aircraft type, and request a
                            personalized flight itinerary.
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-border bg-card p-8 shadow-xl"
                    >
                        <h3 class="mb-6 text-xl font-semibold text-foreground">
                            The Charter Experience
                        </h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg
                                    class="h-6 w-6 shrink-0 text-primary"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    ></path>
                                </svg>
                                <span class="text-foreground"
                                    >Bespoke scheduling with direct routes to
                                    smaller airports.</span
                                >
                            </li>
                            <li class="flex items-start gap-3">
                                <svg
                                    class="h-6 w-6 shrink-0 text-primary"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    ></path>
                                </svg>
                                <span class="text-foreground"
                                    >Diverse fleet selection from turboprops to
                                    heavy business jets.</span
                                >
                            </li>
                            <li class="flex items-start gap-3">
                                <svg
                                    class="h-6 w-6 shrink-0 text-primary"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    ></path>
                                </svg>
                                <span class="text-foreground"
                                    >Dedicated VIP concierge service and
                                    tailored catering.</span
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="relative overflow-hidden rounded-2xl border border-primary/20 bg-gradient-to-br from-primary/10 to-background p-10 text-center shadow-sm"
                >
                    <div class="relative z-10">
                        <h2 class="mb-4 text-3xl font-bold text-foreground">
                            Elevate Your Journey
                        </h2>
                        <p class="mx-auto mb-8 max-w-xl text-muted-foreground">
                            Ready for the ultimate flight experience? Request
                            your private charter today.
                        </p>

                        <button
                            @click="showComingSoon"
                            class="inline-flex transform items-center gap-2 rounded-xl bg-foreground px-8 py-3 font-semibold text-background shadow-lg transition-all duration-200 hover:-translate-y-1 hover:bg-muted-foreground"
                        >
                            Book an Aircraft
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AeroLayout>
</template>
