<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';
import SecurityController from '@/actions/App/Http/Controllers/Settings/SecurityController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import AeroLayout from '@/layouts/AeroLayout.vue';
import { disable, enable } from '@/routes/two-factor';

type Props = {
    canManageTwoFactor?: boolean;
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
};

withDefaults(defineProps<Props>(), {
    canManageTwoFactor: false,
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

// TIMPA LAYOUT BAWAAN SECARA EKSPLISIT
defineOptions({
    layout: AeroLayout,
});

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => clearTwoFactorAuthData());
</script>

<template>
    <Head title="Security Settings" />

    <main
        class="mx-auto min-h-[80vh] max-w-3xl space-y-8 px-4 pt-24 pb-12 sm:px-6 lg:px-8"
    >
        <div>
            <h2 class="text-2xl font-bold text-foreground">
                Security Settings
            </h2>
            <p class="mt-1 text-sm text-muted-foreground">
                Manage your password and two-factor authentication.
            </p>
        </div>

        <div
            class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8"
        >
            <Heading
                variant="small"
                title="Update Password"
                description="Ensure your account is using a long, random password to stay secure."
                class="mb-6"
            />

            <Form
                v-bind="SecurityController.update.form()"
                :options="{ preserveScroll: true }"
                reset-on-success
                :reset-on-error="[
                    'password',
                    'password_confirmation',
                    'current_password',
                ]"
                class="space-y-6"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="current_password" class="text-muted-foreground"
                        >Current password</Label
                    >
                    <PasswordInput
                        id="current_password"
                        name="current_password"
                        class="mt-1 block w-full border-border bg-background"
                        autocomplete="current-password"
                        placeholder="Enter current password"
                    />
                    <InputError :message="errors.current_password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password" class="text-muted-foreground"
                        >New password</Label
                    >
                    <PasswordInput
                        id="password"
                        name="password"
                        class="mt-1 block w-full border-border bg-background"
                        autocomplete="new-password"
                        placeholder="Create a new password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label
                        for="password_confirmation"
                        class="text-muted-foreground"
                        >Confirm new password</Label
                    >
                    <PasswordInput
                        id="password_confirmation"
                        name="password_confirmation"
                        class="mt-1 block w-full border-border bg-background"
                        autocomplete="new-password"
                        placeholder="Confirm your new password"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <Button
                        :disabled="processing"
                        data-test="update-password-button"
                        class="hover:bg-primary-hover bg-primary text-primary-foreground shadow-sm"
                    >
                        Save Password
                    </Button>
                </div>
            </Form>
        </div>

        <div
            v-if="canManageTwoFactor"
            class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8"
        >
            <div class="mb-6 flex items-center justify-between">
                <Heading
                    variant="small"
                    title="Two-Factor Authentication"
                    description="Add additional security to your account using 2FA."
                />
                <span
                    class="rounded-full px-3 py-1 text-[10px] font-extrabold tracking-wider uppercase"
                    :class="
                        twoFactorEnabled
                            ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-400'
                            : 'bg-muted text-muted-foreground'
                    "
                >
                    {{ twoFactorEnabled ? 'Enabled' : 'Disabled' }}
                </span>
            </div>

            <div
                v-if="!twoFactorEnabled"
                class="flex flex-col items-start justify-start space-y-5"
            >
                <p class="text-sm leading-relaxed text-muted-foreground">
                    When you enable two-factor authentication, you will be
                    prompted for a secure pin during login. This pin can be
                    retrieved from a TOTP-supported application like Google
                    Authenticator on your phone.
                </p>

                <div>
                    <Button
                        v-if="hasSetupData"
                        @click="showSetupModal = true"
                        class="hover:bg-primary-hover bg-primary text-primary-foreground"
                    >
                        <ShieldCheck class="mr-2 h-4 w-4" /> Continue Setup
                    </Button>
                    <Form
                        v-else
                        v-bind="enable.form()"
                        @success="showSetupModal = true"
                        #default="{ processing }"
                    >
                        <Button
                            type="submit"
                            :disabled="processing"
                            class="hover:bg-primary-hover bg-primary text-primary-foreground"
                        >
                            Enable 2FA
                        </Button>
                    </Form>
                </div>
            </div>

            <div
                v-else
                class="flex flex-col items-start justify-start space-y-6"
            >
                <p class="text-sm leading-relaxed text-muted-foreground">
                    You will be prompted for a secure, random pin during login,
                    which you can retrieve from the TOTP-supported application
                    on your phone. Keep your recovery codes safe!
                </p>

                <TwoFactorRecoveryCodes />

                <div
                    class="relative mt-4 inline-block w-full border-t border-border pt-6"
                >
                    <Form v-bind="disable.form()" #default="{ processing }">
                        <button
                            type="submit"
                            :disabled="processing"
                            class="rounded-md border border-destructive/50 px-4 py-2 text-sm font-semibold text-destructive transition-colors hover:bg-destructive/10"
                        >
                            Disable 2FA
                        </button>
                    </Form>
                </div>
            </div>

            <TwoFactorSetupModal
                v-model:isOpen="showSetupModal"
                :requiresConfirmation="requiresConfirmation"
                :twoFactorEnabled="twoFactorEnabled"
            />
        </div>
    </main>
</template>

<style>
/* ================= GLOBAL PATCH ================= */
/* 1. Paksa background Modal (Dialog) supaya tidak transparan walau di-teleport */
div[role='dialog'] {
    background-color: hsl(var(--card, 0 0% 100%)) !important;
}
html.dark div[role='dialog'],
.dark div[role='dialog'] {
    background-color: hsl(var(--card, 240 10% 6.5%)) !important;
}

/* 2. Ubah warna Highlight/Block Text menjadi warna biru Primary AeroFlight */
::selection {
    background-color: hsl(221.2 83.2% 53.3% / 0.25) !important;
    color: hsl(221.2 83.2% 53.3%) !important;
}
html.dark ::selection,
.dark ::selection {
    background-color: hsl(217.2 91.2% 59.8% / 0.3) !important;
    color: hsl(217.2 91.2% 59.8%) !important;
}
</style>
