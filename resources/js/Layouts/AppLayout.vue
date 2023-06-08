<template>
    <div>

        <Head :title="title" />
        <el-row>
            <el-col :span="screenWidth > 767 ? isCollapse ? 1 : 3 : 0">
                <aside class="el-scrollbar shadow" aria-label="Sidebar">
                    <el-menu :default-active="active" class="el-menu-vertical-demo hight-menu shadow list-hidden" active-text-color="#ff4de4" background-color="#ffffff " text-color="#550751" :collapse="isCollapse" @open="handleOpen" @close="handleClose">
                        <div class="flex">
                            <div class="flex-none">
                                <span v-if="isCollapse == false">
                                    <img src="/images/logo.png" class="p-1" /></span>
                            </div>
                            <div class="flex-auto">
                                <el-radio-group v-model="isCollapse">
                                    <el-radio-button :label="false" v-if="isCollapse == true" class="p-1"><el-icon>
                                            <fold />
                                        </el-icon>
                                    </el-radio-button>
                                    <el-radio-button :label="true" v-if="isCollapse == false" class="float-right"><el-icon>
                                            <fold />
                                        </el-icon></el-radio-button>
                                </el-radio-group>
                            </div>
                        </div>

                        <el-scrollbar class="mb-5">
                            <el-menu-item index="0">
                                <el-icon>
                                    <histogram />
                                </el-icon>
                                <!-- <Link :href="route('dashboard.get')"> -->
                                <span v-if="isCollapse == false" class="mx-1">
                                    {{ __("auth.app.dashboard") }}</span>
                                <!-- </Link> -->
                            </el-menu-item>
                            <div class="p-20"></div>
                        </el-scrollbar>
                    </el-menu>
                </aside>
            </el-col>
            <el-col :span="screenWidth > 767 ? isCollapse ? 23 : 21 : 24">
                <header v-bind:class="[
                    isCollapse ? 'nav-width-open' : 'nav-width-close',
                ]" class="shadow nav-color">
                    <div class="flex">
                        <div>
                            <button @click="drawer = true" v-if="screenWidth <= 767 && drawer == false" class="bg-pink">
                                <el-icon >
                                    <fold class="text-white my-4 mx-4" />
                                </el-icon>
                            </button>
                        </div>
                        <div class="flex-auto pt-2">
                            <Link as="button" @click="logout" class="text-white text-sm profile-float">
                            <el-tooltip class="box-item" effect="dark" :content="__('auth.sign_out')" placement="button">
                                <font-awesome-icon icon="sign-out-alt" />
                            </el-tooltip>
                            </Link>
                            <el-dropdown class="text-white text-sm profile-float">
                                <div class="text-center text-white">
                                    <strong>Welcome, {{ $page.props.user.full_name }}</strong>
                                    <el-icon class="el-icon--right"><arrow-down /></el-icon>
                                </div>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item class="text-center py-6">
                                            <strong>{{ $page.props.user.email }}</strong>
                                        </el-dropdown-item>
                                        <el-dropdown-item>
                                            <Link :href="route('profile')" :active="route().current('profile')">
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
                    </div>
                </header>
                <!-- Page Heading -->
                <titleHeader class="bg-white shadow" v-if="$slots.titleHeader">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="titleHeader"> </slot>
                    </div>
                </titleHeader>
                <main>
                    <slot></slot>
                </main>
            </el-col>
        </el-row>
        <el-drawer v-model="drawer" size="60%" :with-header="false">
            <header id="el-drawer__title" class="el-drawer__header">
                <span role="heading"><router-link to="/">
                        <img src="/images/logo4.png" class="img-width img-logo" />
                    </router-link>
                </span>
                <button aria-label="close drawer" class="el-drawer__close-btn" type="button" @click="closeNav">
                    <i class="el-drawer__close el-icon el-icon-close" style="width: 0.5em"></i>
                </button>
            </header>
            <div>
                <ul>
                    <Link :href="'/'">
                    <el-row class="font-bold text-color icon-school inline-flex">
                        <el-col :span="2"> <el-icon>
                                <histogram />
                            </el-icon></el-col>
                        <h3>
                            <!-- <Link :href="route('dashboard.get')"> -->
                            <span v-if="isCollapse == false" class="mx-1">
                                {{ __("auth.app.dashboard") }}</span>
                            <!-- </Link> -->
                        </h3>
                    </el-row>
                    </Link>
                    <hr style="
                width: 100%;
                text-align: left;
                margin-left: 0;
                padding: 0.5rem;
              " />
                </ul>
                <hr style="width: 100%; text-align: left; margin-left: 0; padding: 0.5rem" />
            </div>
        </el-drawer>
    </div>
</template>

<script>
    import {
        defineComponent
    } from "vue";
    import {
        ref
    } from "vue";
    import {
        Location,
        Document,
        Menu as IconMenu,
        Setting,
        CloseBold,
        Fold,
        EditPen,
        Notebook,
        Histogram,
        Clock,
    } from "@element-plus/icons-vue";

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Location,
            Document,
            IconMenu,
            Setting,
            CloseBold,
            Fold,
            EditPen,
            Notebook,
            Histogram,
            Clock,
        },

        setup() {
            let drawer = ref(false);
            let showMenu = ref(false);
            let screenWidth = window.screen.width;

            function closeNav() {
                drawer.value = false;
                showMenu.value = false;
            }

            return {
                drawer,
                showMenu,
                closeNav,
                screenWidth
            };
        },

        data() {
            const input = ref("");
            const isCollapse = ref(false);
            const pages = {
                "Admin/Dashboard": "0",
                "Teacher/Classes/": "1",
            };
            let component = ref("0");
            for (var key in pages) {
                if (this.$page.component.includes(key)) component = pages[key];
            }
            const active = ref(component);
            return {
                showingNavigationDropdown: false,
                input,
                isCollapse,
                active,


            };
        },

        methods: {
            logout() {
                this.$inertia.post(route("logout"));
            },
        },
    });
</script>
