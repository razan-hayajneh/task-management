<template>
    <div class="flex-auto pt-2">
        <el-dropdown class="text-white text-sm profile-float">
            <div class="text-center text-white">
                <!-- Current Profile Photo -->
                <div class="img-profile mt-2" v-show="!photoPreview">
                    <img :src="$page.props.user.image_url" :alt="$page.props.user.full_name"
                        class="rounded-full h-12 w-12 object-cover">
                </div>
                <div>
                    <strong>{{ $page.props.user.full_name }}</strong>
                    <el-icon class="el-icon--right"><arrow-down /></el-icon>
                </div>
            </div>
            <template #dropdown>
                <el-dropdown-menu>
                    <el-dropdown-item class="text-center py-6">
                        <strong>{{ $page.props.user.email }}</strong>
                    </el-dropdown-item>
                    <el-dropdown-item>
                        <Link class="dropdown-item" :href="route('profile.show')" :active="route().current('profile.show')">
                        {{ __("auth.app.profile") }}</Link>
                    </el-dropdown-item>
                    <el-dropdown-item>
                        <Link as="button" @click="logout">
                        {{ __("auth.sign_out") }}
                        </Link>
                    </el-dropdown-item>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>
</template>

<script>
import {
    defineComponent
} from "vue";
export default defineComponent({
    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },
    },
});
</script>
