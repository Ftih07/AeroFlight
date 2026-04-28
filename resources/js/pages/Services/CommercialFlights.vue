<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AeroLayout from '@/Layouts/AeroLayout.vue';
</script>

<template>
    <Head title="Commercial Flights - AeroFlight" />

    <AeroLayout>
        <div
            class="min-h-screen bg-background pb-20 text-muted-foreground transition-colors duration-300"
        >
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
                        <svg
                            class="h-4 w-4"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M22 16.08l-10.46-5.23-.46-2.58c-.14-.76-.73-1.34-1.5-1.46L8.14 6.6c-.36-.06-.72.06-.96.3l-.93.93c-.28.28-.35.72-.18 1.08l2.25 4.88-3.4 1.7-2.33-.78c-.3-.1-.63-.04-.88.16L.5 16.1c-.24.2-.32.54-.2.83l3.35 8.04c.14.34.47.56.84.56h13.92c.6 0 1.15-.36 1.4-1.04l2.4-6.4c.15-.4.07-.86-.2-1.2l-2.02-2.8z"
                            />
                        </svg>
                        AeroFlight Services
                    </div>
                    <h1
                        class="mb-6 text-4xl font-extrabold tracking-tight text-foreground md:text-6xl"
                    >
                        Commercial Flights
                    </h1>
                    <p
                        class="mx-auto max-w-3xl text-lg leading-relaxed text-muted-foreground md:text-xl"
                    >
                        Scheduled air travel solutions for your business or
                        leisure needs. We connect you with a global network of
                        airlines through one transparent, easy-to-use platform.
                    </p>
                </div>
            </div>

            <div class="mx-auto mt-16 max-w-5xl px-6 lg:px-8">
                <div
                    class="mb-20 grid grid-cols-1 items-center gap-12 md:grid-cols-2"
                >
                    <div>
                        <h2 class="mb-4 text-3xl font-bold text-foreground">
                            More Than Just a Ticket
                        </h2>
                        <p class="mb-4 leading-relaxed text-muted-foreground">
                            AeroFlight's Commercial Flights service is designed
                            to provide seamless access to hundreds of regular
                            flight routes from top-tier airlines worldwide.
                        </p>
                        <p class="leading-relaxed text-muted-foreground">
                            Unlike charter planes, commercial flights offer
                            fixed schedules, diverse cabin class options
                            (Economy, Business, First Class), and international
                            operational standards that guarantee safety and
                            comfort throughout your journey.
                        </p>
                    </div>

                    <div
                        class="rounded-2xl border border-border bg-card p-8 shadow-xl"
                    >
                        <h3 class="mb-6 text-xl font-semibold text-foreground">
                            Why Choose Us?
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
                                    >Highly flexible routes and flight schedule
                                    options.</span
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
                                    >Secure payment integration and instant
                                    e-ticket issuance.</span
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
                                    >Hassle-free reschedule and refund support
                                    without the complex paperwork.</span
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mb-20">
                    <h2
                        class="mb-8 text-center text-2xl font-bold text-foreground"
                    >
                        Exclusive Benefits
                    </h2>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div
                            class="rounded-xl border border-border bg-card p-6 transition-colors hover:border-primary/50"
                        >
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 text-xl text-primary"
                            >
                                🧳
                            </div>
                            <h4
                                class="mb-2 text-lg font-semibold text-foreground"
                            >
                                Baggage Management
                            </h4>
                            <p class="text-sm text-muted-foreground">
                                Clear cabin and checked baggage quota info
                                during the booking process. Easily add extra
                                baggage weight directly from your dashboard.
                            </p>
                        </div>

                        <div
                            class="rounded-xl border border-border bg-card p-6 transition-colors hover:border-primary/50"
                        >
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 text-xl text-primary"
                            >
                                💺
                            </div>
                            <h4
                                class="mb-2 text-lg font-semibold text-foreground"
                            >
                                Seat Selection
                            </h4>
                            <p class="text-sm text-muted-foreground">
                                Pick your favorite seat ahead of time. Choose a
                                window seat for the view or an aisle seat for
                                extra legroom and mobility.
                            </p>
                        </div>

                        <div
                            class="rounded-xl border border-border bg-card p-6 transition-colors hover:border-primary/50"
                        >
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 text-xl text-primary"
                            >
                                💳
                            </div>
                            <h4
                                class="mb-2 text-lg font-semibold text-foreground"
                            >
                                Seamless Payments & Rewards
                            </h4>
                            <p class="text-sm text-muted-foreground">
                                Enjoy lightning-fast, secure checkouts powered
                                by Stripe. Earn loyalty miles on every booking
                                to unlock exclusive promos and future discounts.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="relative overflow-hidden rounded-2xl border border-primary/20 bg-gradient-to-br from-primary/10 to-background p-10 text-center shadow-sm"
                >
                    <div class="relative z-10">
                        <h2 class="mb-4 text-3xl font-bold text-foreground">
                            Ready to Fly?
                        </h2>
                        <p class="mx-auto mb-8 max-w-xl text-muted-foreground">
                            Start searching for your route now. Get real-time
                            price comparisons and secure your tickets in just a
                            few minutes.
                        </p>

                        <Link
                            href="/flights"
                            class="inline-flex transform items-center gap-2 rounded-xl bg-primary px-8 py-3 font-semibold text-primary-foreground shadow-lg shadow-primary/20 transition-all duration-200 hover:-translate-y-1 hover:bg-primary/90"
                        >
                            Search Flights Now
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
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"
                                ></path>
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AeroLayout>
</template>
