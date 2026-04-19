<script setup lang="ts">
import { Form, Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import DeleteUser from '@/components/DeleteUser.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AeroLayout from '@/layouts/AeroLayout.vue'; 
import { send } from '@/routes/verification';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

defineProps<Props>();

// 2. TIMPA LAYOUT BAWAAN DENGAN AEROLAYOUT SECARA LANGSUNG
defineOptions({
    layout: AeroLayout,
});

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Profile Settings" />

    <main
        class="mx-auto min-h-[80vh] max-w-3xl space-y-8 px-4 pt-24 pb-12 sm:px-6 lg:px-8"
    >
        <div>
            <h2 class="text-2xl font-bold text-foreground">Profile Settings</h2>
            <p class="mt-1 text-sm text-muted-foreground">
                Manage your account information and email address.
            </p>
        </div>

        <div
            class="rounded-2xl border border-border bg-card p-6 shadow-sm sm:p-8"
        >
            <Heading
                variant="small"
                title="Profile Information"
                description="Update your name and email address"
                class="mb-6"
            />

            <Form
                v-bind="ProfileController.update.form()"
                class="space-y-6"
                v-slot="{ errors, processing }"
            >
                <div class="grid gap-2">
                    <Label for="name" class="text-muted-foreground">Name</Label>
                    <Input
                        id="name"
                        class="mt-1 block w-full border-border bg-background text-foreground focus:border-primary"
                        name="name"
                        :default-value="user.name"
                        required
                        autocomplete="name"
                        placeholder="Full name"
                    />
                    <InputError class="mt-2" :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email" class="text-muted-foreground"
                        >Email address</Label
                    >
                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full border-border bg-background text-foreground focus:border-primary"
                        name="email"
                        :default-value="user.email"
                        required
                        autocomplete="username"
                        placeholder="Email address"
                    />
                    <InputError class="mt-2" :message="errors.email" />
                </div>

                <div
                    v-if="mustVerifyEmail && !user.email_verified_at"
                    class="rounded-lg border border-amber-500/20 bg-amber-500/10 p-4"
                >
                    <p class="text-sm text-amber-600 dark:text-amber-400">
                        Your email address is unverified.
                        <Link
                            :href="send()"
                            as="button"
                            class="font-bold underline decoration-amber-500/50 underline-offset-4 transition-colors hover:decoration-amber-500"
                        >
                            Click here to resend the verification email.
                        </Link>
                    </p>

                    <div
                        v-if="status === 'verification-link-sent'"
                        class="mt-2 text-sm font-medium text-emerald-600 dark:text-emerald-400"
                    >
                        A new verification link has been sent to your email
                        address.
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <Button
                        :disabled="processing"
                        data-test="update-profile-button"
                        class="hover:bg-primary-hover bg-primary text-primary-foreground shadow-sm cursor-pointer"
                    >
                        Save Changes
                    </Button>
                </div>
            </Form>
        </div>

        <div
            class="rounded-2xl border border-destructive/30 bg-destructive/5 p-6 shadow-sm sm:p-8"
        >
            <DeleteUser />
        </div>
    </main>
</template>
