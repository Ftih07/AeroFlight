<template>
    <div
        class="aero-root min-h-screen overflow-x-hidden font-sans transition-colors duration-300"
        :data-theme="appearance"
    >
        <Navbar :activeTheme="appearance" @change-theme="setTheme" />

        <slot />

        <Footer />
    </div>
</template>

<!-- eslint-disable vue/block-lang -->
<script setup>
import { ref, onMounted } from 'vue';
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';

const appearance = ref('system');

const applyTheme = (val) => {
    const prefersDark = window.matchMedia(
        '(prefers-color-scheme: dark)',
    ).matches;
    const useDark = val === 'dark' || (val === 'system' && prefersDark);
    document.documentElement.classList.toggle('dark', useDark);
    const root = document.querySelector('.aero-root');

    if (root) {
        root.setAttribute('data-theme', useDark ? 'dark' : 'light');
    }
};

const setTheme = (val) => {
    appearance.value = val;
    localStorage.setItem('appearance', val);
    applyTheme(val);
};

onMounted(() => {
    const saved = localStorage.getItem('appearance') || 'system';
    appearance.value = saved;
    applyTheme(saved);
    window
        .matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', () => {
            if (appearance.value === 'system') {
                applyTheme('system');
            }
        });
});
</script>

<style>
/* Masukkan semua CSS TEMA AEROFLIGHT ORIGINAL kamu kesini (sama persis dengan file awalmu) */
.aero-root,
.aero-root[data-theme='light'] {
    --background: 0 0% 100%;
    --foreground: 240 10% 3.9%;
    --card: 0 0% 100%;
    --card-foreground: 240 10% 3.9%;
    --popover: 0 0% 100%;
    --popover-foreground: 240 10% 3.9%;
    --primary: 221.2 83.2% 53.3%;
    --primary-foreground: 210 40% 98%;
    --muted: 240 4.8% 95.9%;
    --muted-foreground: 240 3.8% 46.1%;
    --accent: 240 4.8% 93%;
    --accent-foreground: 240 10% 3.9%;
    --border: 240 5.9% 90%;
    --destructive: 0 84.2% 60.2%;
    --destructive-foreground: 0 0% 98%;
    background-color: hsl(var(--background));
    color: hsl(var(--foreground));
}

.aero-root[data-theme='dark'],
.dark .aero-root {
    --background: 240 10% 3.9%;
    --foreground: 0 0% 98%;
    --card: 240 10% 6.5%;
    --card-foreground: 0 0% 98%;
    --popover: 240 10% 6.5%;
    --popover-foreground: 0 0% 98%;
    --primary: 217.2 91.2% 59.8%;
    --primary-foreground: 222.2 47.4% 11.2%;
    --muted: 240 3.7% 15.9%;
    --muted-foreground: 240 5% 64.9%;
    --accent: 240 3.7% 20%;
    --accent-foreground: 0 0% 98%;
    --border: 240 3.7% 20%;
    --destructive: 0 62.8% 50%;
    --destructive-foreground: 0 0% 98%;
    background-color: hsl(var(--background));
    color: hsl(var(--foreground));
}

.bg-background {
    background-color: hsl(var(--background));
}
.bg-card {
    background-color: hsl(var(--card));
}
.bg-muted {
    background-color: hsl(var(--muted));
}
.bg-accent {
    background-color: hsl(var(--accent));
}
.bg-primary {
    background-color: hsl(var(--primary));
}
.bg-primary-hover {
    background-color: hsl(var(--primary) / 0.88);
}
.bg-popover {
    background-color: hsl(var(--popover));
}
.text-foreground {
    color: hsl(var(--foreground));
}
.text-muted-foreground {
    color: hsl(var(--muted-foreground));
}
.text-primary {
    color: hsl(var(--primary));
}
.text-primary-foreground {
    color: hsl(var(--primary-foreground));
}
.text-popover-foreground {
    color: hsl(var(--popover-foreground));
}
.text-destructive {
    color: hsl(var(--destructive));
}
.border-border {
    border-color: hsl(var(--border));
}
.aero-nav {
    background-color: hsl(var(--card) / 0.85);
    border-color: hsl(var(--border));
}

.aero-input {
    outline: none;
    transition:
        box-shadow 0.15s ease,
        border-color 0.15s ease;
}
.aero-input:focus {
    border-color: hsl(var(--primary) / 0.6);
    box-shadow: 0 0 0 3px hsl(var(--primary) / 0.15);
}

.dropdown-enter-active,
.dropdown-leave-active {
    transition:
        opacity 0.18s ease,
        transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-6px) scale(0.97);
}
.slide-down-enter-active,
.slide-down-leave-active {
    transition:
        opacity 0.18s ease,
        transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}
.slide-down-enter-from,
.slide-down-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}
html {
    scroll-behavior: smooth;
}
* {
    box-sizing: border-box;
}
</style>
