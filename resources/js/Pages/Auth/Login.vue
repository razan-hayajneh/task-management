<template>
    <div class="semi-circle"></div>
    <div class="semi-circle-right"></div>
    <div class="bg-img min-h-screen ">
        <div class="h-24"></div>
        <el-card class="box-card">
            <div class="login-form">
                <div class="m-5">
                    <jet-validation-errors class="mb-4" />
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="email" value='email' />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
                        </div>
                        <div class="mt-4">
                            <jet-label for="password" value='password' />
                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                        </div>
                        <div class="block mt-4">
                            <label class="flex items-center">
                                <jet-checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ml-2 text-sm text-gray-600 m-left">{{ __("auth.remember_me") }}</span>
                            </label>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <Link v-if="canResetPassword" :href="route('password.request')" class="m-left underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __("auth.confirm_passwords.forgot_your_password") }}
                            </Link>
                            <jet-button class="ml-4 btn-form" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ __("auth.sign_in") }}
                            </jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </el-card>
        <div class="semi-circle-bottom"></div>
    </div>
</template>
<script>
    import {
        defineComponent
    } from 'vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import {
        Head,
        Link
    } from '@inertiajs/inertia-vue3';
    export default defineComponent({
        components: {
            Head,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },
        props: {
            canResetPassword: Boolean,
            status: String
        },
        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false,
                })
            }
        },
        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ...data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    })
</script>
