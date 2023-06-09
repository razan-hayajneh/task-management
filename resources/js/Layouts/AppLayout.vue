<template>
    <div>

        <Head :title="title" />
        <el-row>
            <el-col :span="screenWidth > 767 ? isCollapse ? 1 : 3 : 0">

                <aside class="el-scrollbar shadow" aria-label="Sidebar">
                    <el-menu :default-active="active" class="el-menu-vertical-demo hight-menu shadow list-hidden"
                        active-text-color="#ff4de4" background-color="#ffffff " text-color="#550751" :collapse="isCollapse"
                        @open="handleOpen" @close="handleClose">
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

                        <SideBarMenu :isCollapse="isCollapse" />

                    </el-menu>
                </aside>F
            </el-col>
            <el-col :span="screenWidth > 767 ? isCollapse ? 23 : 21 : 24">
                <header v-bind:class="[
                    isCollapse ? 'nav-width-open' : 'nav-width-close',
                ]" class="shadow nav-color">
                    <div class="flex">
                        <div>
                            <button @click="drawer = true" v-if="screenWidth <= 767 && drawer == false" class="bg-pink">
                                <el-icon>
                                    <fold class="text-white my-4 mx-4" />
                                </el-icon>
                            </button>
                        </div>
                        <NavBar/>
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
            <Drawer />
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
    User,
    Document,
    Menu as IconMenu,
    Fold,
} from "@element-plus/icons-vue";
import SideBarMenu from "@/Components/AppLayout/SideBarMenu";
import Drawer from "@/Components/AppLayout/Drawer.vue";
import NavBar from "@/Components/AppLayout/NavBar.vue";

export default defineComponent({
    props: {
        title: String,
    },

    components: {
        Document,
        IconMenu,
        Fold,
        User,
        SideBarMenu,
        Drawer,
        NavBar,
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
        const isCollapse = ref(false);
        const pages = {
            "Admin/Dashboard": "0",
            "Admin/Admin": "1",
            "Admin/TeamMember": "2",
            "Admin/Category": "3",
        };
        let component = ref("0");
        for (var key in pages) {
            if (this.$page.component.includes(key)) component = pages[key];
        }
        const active = ref(component);
        return {
            isCollapse,
            active,
        };
    },

});
</script>
