<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { useTemplateRef } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';

const passwordInput = useTemplateRef('passwordInput');
</script>

<template>
    <div class="space-y-6">
        <Heading
            variant="small"
            title="Delete Account"
            description="Delete your account and all of its resources. This action cannot be reversed."
        />

        <div
            class="space-y-4 rounded-xl border border-red-200 bg-red-50 p-5 transition-all dark:border-red-500/20 dark:bg-red-500/10"
        >
            <div class="relative space-y-1 text-red-600 dark:text-red-400">
                <p
                    class="flex items-center gap-2 text-sm font-bold tracking-wide uppercase"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                        />
                    </svg>
                    Danger Zone
                </p>
                <p
                    class="text-sm font-medium text-red-800 opacity-90 dark:text-red-300"
                >
                    Once your account is deleted, all of its resources and data
                    will be permanently deleted. Before deleting your account,
                    please download any data or information that you wish to
                    retain.
                </p>
            </div>

            <Dialog>
                <DialogTrigger as-child>
                    <button
                        class="mt-2 inline-flex items-center justify-center rounded-md bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none dark:focus:ring-offset-gray-900"
                        data-test="delete-user-button"
                    >
                        Delete Account
                    </button>
                </DialogTrigger>

                <DialogContent
                    class="aero-root rounded-2xl border-border bg-card p-6 text-foreground shadow-2xl sm:max-w-md"
                >
                    <Form
                        v-bind="ProfileController.destroy.form()"
                        reset-on-success
                        @error="() => passwordInput?.focus()"
                        :options="{
                            preserveScroll: true,
                        }"
                        class="space-y-6 pt-4"
                        v-slot="{ errors, processing, reset, clearErrors }"
                    >
                        <DialogHeader
                            class="flex flex-col items-center space-y-3 text-center"
                        >
                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-full bg-red-100 dark:bg-red-500/20"
                            >
                                <svg
                                    class="h-7 w-7 text-red-600 dark:text-red-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                    />
                                </svg>
                            </div>
                            <DialogTitle
                                class="text-xl font-bold text-foreground"
                            >
                                Delete Account
                            </DialogTitle>
                            <DialogDescription
                                class="text-center text-sm text-muted-foreground"
                            >
                                Are you sure you want to delete your account?
                                This action is permanent. Please enter your
                                password to confirm.
                            </DialogDescription>
                        </DialogHeader>

                        <div class="grid gap-2 px-1">
                            <Label
                                for="password"
                                class="text-sm font-semibold text-muted-foreground"
                                >Confirm Password</Label
                            >
                            <PasswordInput
                                id="password"
                                name="password"
                                ref="passwordInput"
                                placeholder="Enter your password"
                                class="border-border bg-background text-foreground"
                            />
                            <InputError :message="errors.password" />
                        </div>

                        <DialogFooter
                            class="flex w-full flex-col-reverse gap-3 pt-4 sm:flex-row sm:justify-end"
                        >
                            <DialogClose as-child>
                                <button
                                    type="button"
                                    class="w-full rounded-md border border-border bg-background px-4 py-2 text-sm font-semibold text-foreground transition-colors hover:bg-muted sm:w-auto"
                                    @click="
                                        () => {
                                            clearErrors();
                                            reset();
                                        }
                                    "
                                >
                                    Cancel
                                </button>
                            </DialogClose>

                            <button
                                type="submit"
                                :disabled="processing"
                                class="w-full rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700 disabled:opacity-50 sm:w-auto"
                                data-test="confirm-delete-user-button"
                            >
                                <span v-if="processing">Deleting...</span>
                                <span v-else>Yes, delete account</span>
                            </button>
                        </DialogFooter>
                    </Form>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template>
