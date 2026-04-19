<template>
    <footer class="border-t border-border bg-card py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 grid grid-cols-2 gap-6 sm:grid-cols-4">
                <div class="col-span-2 sm:col-span-1">
                    <div class="mb-3 flex items-center gap-2">
                        <div
                            class="flex h-6 w-6 items-center justify-center rounded-md bg-primary"
                        >
                            <svg
                                class="h-3.5 w-3.5 text-primary-foreground"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M22 16v-2l-8-5V5c0-1-1.2-1.8-2-1.8S10 4 10 5v4L2 14v2l8-2v4l-2 1v1.5l4-1.2 4 1.2V19l-2-1v-4l8 2z"
                                />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-foreground"
                            >AeroFlight</span
                        >
                    </div>
                    <p class="text-xs leading-relaxed text-muted-foreground">
                        Modern flight management platform for all your air
                        travel needs.
                    </p>
                </div>
                <div v-for="col in footerLinks" :key="col.title">
                    <p
                        class="mb-3 text-xs font-semibold tracking-wider text-foreground uppercase"
                    >
                        {{ col.title }}
                    </p>
                    <ul class="space-y-1.5">
                        <li v-for="link in col.links" :key="link">
                            <a
                                href="#"
                                class="text-xs text-muted-foreground transition hover:text-foreground"
                                >{{ link }}</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="flex flex-col items-center justify-between gap-2 border-t border-border pt-5 sm:flex-row"
            >
                <p class="text-xs text-muted-foreground">
                    &copy; 2026 AeroFlight by Naufal Fathi. Part of Portfolio Project.
                </p>
                <div class="flex gap-4">
                    <a
                        href="#"
                        class="text-xs text-muted-foreground hover:text-foreground"
                        >Privacy Policy</a
                    >
                    <a
                        href="#"
                        class="text-xs text-muted-foreground hover:text-foreground"
                        >Terms of Service</a
                    >
                </div>
            </div>
        </div>
    </footer>
</template>

<!-- eslint-disable vue/block-lang -->
<script setup>
const footerLinks = [
    {
        title: 'Services',
        links: [
            'Commercial Flights',
            'Air Cargo',
            'Charter Aircraft',
            'Travel Insurance',
        ],
    },
    { title: 'Company', links: ['About Us', 'Careers', 'News', 'Partners'] },
    {
        title: 'Support',
        links: ['Help Center', 'Contact Us', 'Flight Status', 'Track Cargo'],
    },
];
</script>
