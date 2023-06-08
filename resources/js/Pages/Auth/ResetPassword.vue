<template>

    <Head title="Reset Password" />

    <div class="semi-circle"></div>
    <div class="semi-circle-right"></div>
    <div class="bg-img min-h-screen ">
        <div class="h-24"></div>
        <el-card class="box-card">
            <div class="login-form">
                <div class="m-5">

                    <jet-validation-errors class="mb-4" />

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password" value="Password" />
                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password_confirmation" value="Confirm Password" />
                            <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <jet-button class="ml-4 btn-form" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Reset Password
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
    } from 'vue';
    import {
        Head
    } from '@inertiajs/inertia-vue3';
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default defineComponent({
        components: {
            Head,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors
        },

        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    })
</script>
