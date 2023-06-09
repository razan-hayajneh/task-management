<template>
    <app-layout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <update-profile-information-form :user="$page.props.user" />
                    <jet-section-border />
                </div>
                <div v-if="$page.props.jetstream.canUpdatePassword">
                    <update-password-form class="mt-10 sm:mt-0" />
                    <jet-section-border />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import UpdatePasswordForm from '@/Components/Profile/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Components/Profile/UpdateProfileInformationForm.vue'

export default defineComponent({
    components: {
        AppLayout,
        JetSectionBorder,
        UpdatePasswordForm,
        UpdateProfileInformationForm,
    },
})
</script>
