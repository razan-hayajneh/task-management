<template>

    <div class="semi-circle"></div>
    <div class="semi-circle-right"></div>
    <div class="bg-img min-h-screen ">
        <div class="h-24"></div>
        <el-card class="box-card">
            <div class="login-form">
                <div class="m-5">
                    <div class="mb-4 text-sm text-gray-600">
                        This is a secure area of the application. Please confirm your password before continuing.
                    </div>

                    <jet-validation-errors class="mb-4" />

                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="password" value="Password" />
                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" autofocus />
                        </div>

                        <div class="flex justify-end mt-4">
                            <jet-button class="ml-4 btn-form" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Confirm
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

        data() {
            return {
                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.confirm'), {
                    onFinish: () => this.form.reset(),
                })
            }
        }
    })
</script>
