<template>

    <Head title="Forgot Password" />

    <div class="semi-circle"></div>
    <div class="semi-circle-right"></div>
    <div class="bg-img min-h-screen ">
        <div class="h-24"></div>
        <el-card class="box-card">
            <div class="login-form">
                <div class="m-5">
                    <div class="mb-4 text-sm text-gray-600">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </div>

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>

                    <jet-validation-errors class="mb-4" />

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <jet-button class="ml-4 btn-form" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Email Password Reset Link
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
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    })
</script>
