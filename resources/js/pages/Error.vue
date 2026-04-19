<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
import AeroLayout from '@/layouts/AeroLayout.vue';

const props = defineProps({
    status: Number,
});
/**
 * Dynamic title mapping (aviation tone)
 */
const title = computed(() => {
    // Beri tahu TypeScript bahwa ini adalah objek dengan key angka dan value string
    const titles: Record<number, string> = {
        503: 'Service Temporarily Grounded',
        500: 'In-Flight System Error',
        404: 'Flight Not Found',
        403: 'Access Restricted',
        429: 'Too Many Requests',
    };

    // Cek apakah status ada, baru ambil nilainya
    return (props.status && titles[props.status]) || 'Unexpected Error';
});

/**
 * Dynamic description mapping
 */
const description = computed(() => {
    const descriptions: Record<number, string> = {
        503: 'We are performing scheduled maintenance. Please standby while we prepare for takeoff again.',
        500: 'Unexpected turbulence detected. Our engineering crew is stabilizing the system.',
        404: 'The flight or route you are looking for is no longer available or has been redirected.',
        403: 'You do not have the required boarding clearance to access this area.',
        429: 'You are navigating too quickly. Please wait a moment before continuing.',
    };

    return (
        (props.status && descriptions[props.status]) ||
        'An unexpected system issue has occurred. Please try again later.'
    );
});

/**
 * Smart CTA
 */
const primaryAction = computed(() => {
    if (props.status === 404) {
        return { label: 'Search Flights', href: '/flights' };
    }

    return { label: 'Return to Home', href: '/' };
});

/**
 * Parallax state (mouse-based)
 */
const offset = ref({ x: 0, y: 0 });

onMounted(() => {
    window.addEventListener('mousemove', (e) => {
        const x = (e.clientX / window.innerWidth - 0.5) * 20;
        const y = (e.clientY / window.innerHeight - 0.5) * 20;
        offset.value = { x, y };
    });
});
</script>

<template>
    <AeroLayout>
        <Head :title="title" />

        <div
            class="relative mt-14 flex min-h-[80vh] items-center justify-center overflow-hidden px-4 py-16 text-center"
        >
            <!-- 🌌 Layered Background -->
            <div class="absolute inset-0 -z-10">
                <!-- base gradient -->
                <div
                    class="absolute inset-0 bg-gradient-to-br from-background via-background to-primary/5"
                ></div>

                <!-- glow layer -->
                <div
                    class="absolute h-[600px] w-[600px] rounded-full bg-primary/20 blur-3xl transition-transform duration-300"
                    :style="{
                        transform: `translate(${offset.x}px, ${offset.y}px)`,
                    }"
                ></div>

                <div
                    class="absolute right-0 bottom-0 h-[400px] w-[400px] rounded-full bg-blue-400/10 blur-3xl transition-transform duration-300"
                    :style="{
                        transform: `translate(${-offset.x}px, ${-offset.y}px)`,
                    }"
                ></div>
            </div>

            <!-- ✈️ Content -->
            <div class="w-full max-w-xl space-y-8">
                <!-- Floating icon -->
                <div
                    class="animate-float mx-auto flex h-24 w-24 items-center justify-center rounded-2xl bg-primary/10 shadow-xl backdrop-blur-sm"
                >
                    <svg
                        class="h-12 w-12 text-primary"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                        />
                    </svg>
                </div>

                <!-- Text -->
                <div class="space-y-4">
                    <h1
                        class="text-8xl font-extrabold tracking-tight text-primary/10"
                    >
                        {{ status }}
                    </h1>

                    <h2 class="text-3xl font-semibold text-foreground">
                        {{ title }}
                    </h2>

                    <p
                        class="mx-auto max-w-md leading-relaxed text-muted-foreground"
                    >
                        {{ description }}
                    </p>
                </div>

                <!-- CTA -->
                <div class="flex justify-center gap-4">
                    <Link
                        :href="primaryAction.href"
                        class="group inline-flex items-center justify-center rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground shadow-lg transition-all hover:-translate-y-1 hover:shadow-2xl active:scale-95"
                    >
                        {{ primaryAction.label }}
                        <span
                            class="ml-2 transition-transform group-hover:translate-x-1"
                            >→</span
                        >
                    </Link>
                </div>
            </div>
        </div>
    </AeroLayout>
</template>

<style scoped>
@keyframes float {
    0%,
    100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-float {
    animation: float 5s ease-in-out infinite;
}
</style>
