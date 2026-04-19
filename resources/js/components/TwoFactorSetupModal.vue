<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { useClipboard } from '@vueuse/core';
import { Check, Copy, ScanLine } from 'lucide-vue-next';
import { computed, nextTick, ref, useTemplateRef, watch } from 'vue';
import AlertError from '@/components/AlertError.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    InputOTP,
    InputOTPGroup,
    InputOTPSlot,
} from '@/components/ui/input-otp';
import { Spinner } from '@/components/ui/spinner';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import { confirm } from '@/routes/two-factor';
import type { TwoFactorConfigContent } from '@/types';

type Props = {
    requiresConfirmation: boolean;
    twoFactorEnabled: boolean;
};

const props = defineProps<Props>();
const isOpen = defineModel<boolean>('isOpen');

const { copy, copied } = useClipboard();
const { qrCodeSvg, manualSetupKey, clearSetupData, fetchSetupData, errors } =
    useTwoFactorAuth();

const showVerificationStep = ref(false);
const code = ref<string>('');

const pinInputContainerRef = useTemplateRef('pinInputContainerRef');

const modalConfig = computed<TwoFactorConfigContent>(() => {
    if (props.twoFactorEnabled) {
        return {
            title: '2FA Enabled',
            description:
                'Two-factor authentication is now active. Your account is secured.',
            buttonText: 'Close',
        };
    }

    if (showVerificationStep.value) {
        return {
            title: 'Verify Code',
            description: 'Enter the 6-digit code from your authenticator app',
            buttonText: 'Confirm',
        };
    }

    return {
        title: 'Enable two-factor authentication',
        description:
            'To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app',
        buttonText: 'Continue',
    };
});

const handleModalNextStep = () => {
    if (props.requiresConfirmation) {
        showVerificationStep.value = true;

        nextTick(() => {
            pinInputContainerRef.value?.querySelector('input')?.focus();
        });

        return;
    }

    clearSetupData();
    isOpen.value = false;
};

const resetModalState = () => {
    if (props.twoFactorEnabled) {
        clearSetupData();
    }

    showVerificationStep.value = false;
    code.value = '';
};

watch(
    () => isOpen.value,
    async (isOpen) => {
        if (!isOpen) {
            resetModalState();

            return;
        }

        if (!qrCodeSvg.value) {
            await fetchSetupData();
        }
    },
);
</script>

<template>
    <Dialog :open="isOpen" @update:open="isOpen = $event">
        <DialogContent
            class="aero-root rounded-2xl border-border bg-card p-6 text-foreground shadow-2xl sm:max-w-md"
        >
            <DialogHeader
                class="flex flex-col items-center justify-center space-y-3 pt-4 pb-2"
            >
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl border border-primary/20 bg-primary/10 text-primary shadow-sm"
                >
                    <ScanLine class="h-6 w-6" />
                </div>

                <DialogTitle
                    class="text-center text-xl font-black tracking-tight text-foreground"
                >
                    {{ modalConfig.title }}
                </DialogTitle>
                <DialogDescription
                    class="text-center text-sm font-medium text-muted-foreground"
                >
                    {{ modalConfig.description }}
                </DialogDescription>
            </DialogHeader>

            <div
                class="flex w-full flex-col items-center justify-center space-y-6 pt-2"
            >
                <template v-if="!showVerificationStep">
                    <AlertError
                        v-if="errors?.length"
                        :errors="errors"
                        class="w-full"
                    />

                    <template v-else>
                        <div
                            class="relative mx-auto flex h-48 w-48 items-center justify-center overflow-hidden rounded-xl border border-border bg-white p-3 shadow-inner"
                        >
                            <div
                                v-if="!qrCodeSvg"
                                class="flex h-full w-full items-center justify-center bg-gray-50"
                            >
                                <Spinner class="h-6 w-6 text-primary" />
                            </div>
                            <div
                                v-else
                                v-html="qrCodeSvg"
                                class="flex h-full w-full items-center justify-center text-black [&>svg]:h-full [&>svg]:w-full"
                            />
                        </div>

                        <Button
                            class="hover:bg-primary-hover w-full bg-primary text-primary-foreground shadow-sm"
                            @click="handleModalNextStep"
                            size="lg"
                        >
                            {{ modalConfig.buttonText }}
                        </Button>

                        <div
                            class="relative flex w-full items-center justify-center py-1"
                        >
                            <div
                                class="absolute inset-0 top-1/2 h-[1px] w-full bg-border"
                            />
                            <span
                                class="relative bg-card px-3 text-[10px] font-bold tracking-widest text-muted-foreground uppercase"
                            >
                                or, enter the code manually
                            </span>
                        </div>

                        <div
                            class="flex w-full overflow-hidden rounded-lg border border-border bg-muted/30 transition-colors focus-within:border-primary/50"
                        >
                            <div
                                v-if="!manualSetupKey"
                                class="flex w-full items-center justify-center p-3 text-muted-foreground"
                            >
                                <Spinner class="h-4 w-4" />
                            </div>
                            <template v-else>
                                <input
                                    type="text"
                                    readonly
                                    :value="manualSetupKey"
                                    class="w-full border-none bg-transparent px-4 py-3 text-center font-mono text-sm font-bold tracking-[0.1em] text-foreground focus:ring-0 focus:outline-none"
                                />
                                <button
                                    @click="copy(manualSetupKey || '')"
                                    class="flex items-center justify-center border-l border-border bg-background px-4 transition-colors hover:bg-muted"
                                >
                                    <Check
                                        v-if="copied"
                                        class="h-4 w-4 text-emerald-500"
                                    />
                                    <Copy
                                        v-else
                                        class="h-4 w-4 text-muted-foreground"
                                    />
                                </button>
                            </template>
                        </div>
                    </template>
                </template>

                <template v-else>
                    <Form
                        v-bind="confirm.form()"
                        error-bag="confirmTwoFactorAuthentication"
                        reset-on-error
                        @finish="code = ''"
                        @success="isOpen = false"
                        v-slot="{ errors, processing }"
                        class="w-full"
                    >
                        <input type="hidden" name="code" :value="code" />

                        <div
                            ref="pinInputContainerRef"
                            class="flex w-full flex-col items-center justify-center space-y-8"
                        >
                            <InputOTP
                                id="otp"
                                v-model="code"
                                :maxlength="6"
                                :disabled="processing"
                            >
                                <InputOTPGroup class="gap-2">
                                    <InputOTPSlot
                                        v-for="index in 6"
                                        :key="index"
                                        :index="index - 1"
                                        class="h-12 w-10 rounded-lg border border-border bg-background text-xl font-black text-foreground shadow-sm transition-all focus:scale-105 focus:border-primary focus:ring-2 focus:ring-primary/20 sm:h-14 sm:w-12"
                                    />
                                </InputOTPGroup>
                            </InputOTP>
                            <InputError
                                v-if="errors?.code"
                                :message="errors.code"
                                class="text-center"
                            />

                            <div class="flex w-full items-center gap-3">
                                <Button
                                    type="button"
                                    variant="outline"
                                    class="w-full flex-1 border-border bg-transparent text-foreground hover:bg-muted"
                                    @click="showVerificationStep = false"
                                    :disabled="processing"
                                    size="lg"
                                >
                                    Back
                                </Button>
                                <Button
                                    type="submit"
                                    class="hover:bg-primary-hover w-full flex-1 bg-primary text-primary-foreground shadow-sm"
                                    :disabled="processing || code.length < 6"
                                    size="lg"
                                >
                                    <span v-if="processing">Verifying...</span>
                                    <span v-else>Confirm</span>
                                </Button>
                            </div>
                        </div>
                    </Form>
                </template>
            </div>
        </DialogContent>
    </Dialog>
</template>
