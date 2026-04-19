<template>
    <nav
        class="aero-nav fixed z-50 w-full border-b bg-card/80 backdrop-blur-md transition-all duration-500 ease-in-out"
        :class="[
            scrolled
                ? 'h-14 border-transparent shadow-lg shadow-black/5'
                : 'h-16 border-border sm:h-20',
        ]"
    >
        <div class="mx-auto h-full max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-full items-center justify-between gap-4">
                <Link
                    href="/"
                    class="group flex flex-shrink-0 items-center gap-2"
                >
                    <div
                        class="group-hover:bg-primary-hover flex items-center justify-center rounded-md bg-primary transition-all duration-300 group-hover:scale-105"
                        :class="
                            scrolled ? 'h-7 w-7' : 'h-8 w-8 sm:h-10 sm:w-10'
                        "
                    >
                        <svg
                            class="text-primary-foreground transition-all duration-300"
                            :class="
                                scrolled ? 'h-4 w-4' : 'h-4 w-4 sm:h-5 sm:w-5'
                            "
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M22 16v-2l-8-5V5c0-1-1.2-1.8-2-1.8S10 4 10 5v4L2 14v2l8-2v4l-2 1v1.5l4-1.2 4 1.2V19l-2-1v-4l8 2z"
                            />
                        </svg>
                    </div>
                    <span
                        class="font-bold text-foreground transition-all duration-300 group-hover:text-primary"
                        :class="scrolled ? 'text-base' : 'text-lg sm:text-xl'"
                        >AeroFlight</span
                    >
                </Link>

                <div class="hidden items-center gap-2 md:flex">
                    <a
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="group relative rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:text-foreground"
                    >
                        {{ link.label }}
                        <span
                            class="absolute bottom-1 left-1/2 h-[2px] w-0 -translate-x-1/2 bg-primary transition-all duration-300 ease-out group-hover:w-3/4"
                        ></span>
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <div
                        class="hidden items-center rounded-lg border border-border bg-muted p-0.5 transition-colors duration-300 hover:border-border/80 sm:flex"
                    >
                        <button
                            v-for="t in themes"
                            :key="t.value"
                            @click="updateTheme(t.value)"
                            :title="t.label"
                            :class="
                                activeTheme === t.value
                                    ? 'bg-background text-foreground shadow-sm'
                                    : 'text-muted-foreground hover:text-foreground'
                            "
                            class="flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-xs font-medium transition-all duration-200"
                        >
                            <span
                                class="inline-flex h-3.5 w-3.5"
                                v-html="t.icon"
                            ></span>
                            <span class="hidden lg:inline">{{ t.label }}</span>
                        </button>
                    </div>

                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="flex h-9 w-9 items-center justify-center rounded-md border border-border bg-muted text-muted-foreground transition-colors hover:bg-accent md:hidden"
                    >
                        <svg
                            v-if="!mobileMenuOpen"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                        <svg
                            v-else
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                    <div
                        v-if="isLoggedIn"
                        class="relative"
                        ref="profileDropdownRef"
                    >
                        <button
                            @click="profileOpen = !profileOpen"
                            class="group flex items-center gap-2.5 rounded-full border border-border bg-muted py-1 pr-3 pl-1 transition-all hover:bg-accent hover:shadow-sm"
                        >
                            <div
                                class="flex h-7 w-7 items-center justify-center rounded-full bg-primary text-xs font-bold text-primary-foreground shadow-inner transition-transform group-hover:scale-105"
                            >
                                {{ userInitials }}
                            </div>
                            <span
                                class="hidden text-sm font-semibold text-foreground sm:block"
                                >{{ userName }}</span
                            >
                            <svg
                                class="h-3.5 w-3.5 text-muted-foreground transition-transform duration-300"
                                :class="{
                                    'rotate-180 text-foreground': profileOpen,
                                }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>

                        <transition name="dropdown">
                            <div
                                v-if="profileOpen"
                                class="absolute top-full right-0 mt-2 w-60 origin-top-right rounded-2xl border border-border bg-popover shadow-2xl shadow-black/10"
                            >
                                <div class="border-b border-border px-5 py-4">
                                    <p
                                        class="truncate text-sm font-bold text-popover-foreground"
                                    >
                                        {{ userName }}
                                    </p>
                                    <p
                                        class="truncate text-xs text-muted-foreground"
                                    >
                                        {{ userEmail }}
                                    </p>
                                </div>
                                <div class="space-y-0.5 p-2">
                                    <Link
                                        v-for="item in filteredMenuItems"
                                        :key="item.label"
                                        :href="item.href"
                                        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-popover-foreground transition-colors hover:bg-accent hover:text-foreground"
                                    >
                                        <span
                                            class="inline-flex h-4 w-4 flex-shrink-0 text-muted-foreground"
                                            v-html="item.icon"
                                        ></span>
                                        {{ item.label }}
                                    </Link>
                                    <div
                                        class="my-1 border-t border-border"
                                    ></div>
                                    <Link
                                        href="/logout"
                                        method="post"
                                        as="button"
                                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-destructive transition-colors hover:bg-destructive/10"
                                    >
                                        <span
                                            class="inline-flex h-4 w-4 flex-shrink-0"
                                        >
                                            <svg
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                                />
                                            </svg>
                                        </span>
                                        Log Out
                                    </Link>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <div v-else class="hidden items-center gap-3 sm:flex">
                        <Link
                            href="/login"
                            class="rounded-lg px-4 py-2 text-sm font-semibold text-muted-foreground transition-colors hover:bg-accent hover:text-foreground"
                            >Log in</Link
                        >
                        <Link
                            href="/register"
                            class="hover:bg-primary-hover rounded-lg bg-primary px-4 py-2 text-sm font-bold text-primary-foreground shadow-sm transition-all hover:shadow-md"
                            >Get Started</Link
                        >
                    </div>
                </div>
            </div>
        </div>

        <transition name="slide-down">
            <div
                v-if="mobileMenuOpen"
                class="border-t border-border bg-card shadow-xl md:hidden"
            >
                <div class="space-y-1 p-4">
                    <a
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        @click="mobileMenuOpen = false"
                        class="block rounded-xl px-4 py-3 text-base font-semibold text-muted-foreground transition-colors hover:bg-accent hover:text-foreground"
                        >{{ link.label }}</a
                    >
                    <div class="mt-4 space-y-4 border-t border-border pt-4">
                        <div class="flex items-center justify-between px-2">
                            <span
                                class="text-sm font-medium text-muted-foreground"
                                >Theme</span
                            >
                            <div
                                class="flex items-center rounded-lg border border-border bg-muted p-1"
                            >
                                <button
                                    v-for="t in themes"
                                    :key="t.value"
                                    @click="updateTheme(t.value)"
                                    :class="
                                        activeTheme === t.value
                                            ? 'bg-background text-foreground shadow-sm'
                                            : 'text-muted-foreground'
                                    "
                                    class="rounded-md px-3 py-1.5 text-xs font-semibold transition-all"
                                >
                                    {{ t.label }}
                                </button>
                            </div>
                        </div>
                        <div
                            v-if="!isLoggedIn"
                            class="grid grid-cols-2 gap-3 pt-2"
                        >
                            <Link
                                href="/login"
                                class="flex items-center justify-center rounded-lg border border-border bg-background px-4 py-2.5 text-sm font-bold text-foreground transition-colors hover:bg-accent"
                                >Log in</Link
                            >
                            <Link
                                href="/register"
                                class="flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-bold text-primary-foreground shadow-sm"
                                >Get Started</Link
                            >
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </nav>
</template>

<!-- eslint-disable vue/block-lang -->
<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

defineProps({
    activeTheme: String,
});

const emit = defineEmits(['change-theme']);

const page = usePage();
const user = computed(() => page.props.auth?.user);
const isLoggedIn = computed(() => !!user.value);
const userName = computed(() => user.value?.name || '');
const userEmail = computed(() => user.value?.email || '');

const userInitials = computed(() => {
    if (!userName.value) {
        return '';
    }

    return userName.value
        .split(' ')
        .map((n) => n[0])
        .join('')
        .slice(0, 2)
        .toUpperCase();
});

const scrolled = ref(false);
const mobileMenuOpen = ref(false);
const profileOpen = ref(false);
const profileDropdownRef = ref(null);

const navLinks = [
    { href: '/#home', label: 'Home' },
    { href: '/#services', label: 'Services' },
    { href: '/#routes', label: 'Routes' },
    { href: '#about', label: 'About' },
    { href: '#faq', label: 'FAQ' },
];

// ── Theme ─────────────────────────────────────────────
const themes = [
    {
        value: 'light',
        label: 'Light',
        icon: '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>',
    },
    {
        value: 'dark',
        label: 'Dark',
        icon: '<svg viewBox="0 0 20 20" fill="currentColor"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>',
    },
    {
        value: 'system',
        label: 'System',
        icon: '<svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/></svg>',
    },
];

const updateTheme = (value) => {
    localStorage.setItem('appearance', value);

    emit('change-theme', value);

    if (value === 'dark') {
        document.documentElement.classList.add('dark');
    } else if (value === 'light') {
        document.documentElement.classList.remove('dark');
    } else {
        const isDark = window.matchMedia(
            '(prefers-color-scheme: dark)',
        ).matches;
        document.documentElement.classList.toggle('dark', isDark);
    }
};

// ── Profile Menu ───────────────────────────────────────
const profileMenuItems = [
    {
        label: 'My Bookings',
        href: '/my-bookings',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" /></svg>',
    },
    {
        label: 'Profile Settings',
        href: '/settings/profile',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>',
    },
    {
        label: 'Security Settings',
        href: '/settings/security',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>',
    },
];

const filteredMenuItems = computed(() => {
    const isAdmin = page.props.auth?.is_admin;

    if (isAdmin) {
        return [];
    }

    return profileMenuItems;
});

// ── Events ─────────────────────────────────────────────
const handleOutsideClick = (e) => {
    if (
        profileDropdownRef.value &&
        !profileDropdownRef.value.contains(e.target)
    ) {
        profileOpen.value = false;
    }
};

const handleScroll = () => {
    scrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });
    document.addEventListener('click', handleOutsideClick);
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('click', handleOutsideClick);
});
</script>
