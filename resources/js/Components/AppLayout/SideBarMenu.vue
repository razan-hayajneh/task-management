<template>
    <el-scrollbar class="mb-5">
        <Link :href="route('dashboard')" :active="route().current('dashboard')">
        <el-menu-item index="0">
            <el-icon>
                <histogram />
            </el-icon>
            <span v-if="isCollapse == false" class="mx-1">Dashboard</span>
        </el-menu-item> </Link>
        <el-menu-item index="1">
            <el-icon>
                <User />
            </el-icon>
            <side-bar-item :isCollapse="isCollapse" label="Admins" routeName="admins" />
        </el-menu-item>
        <el-menu-item index="2">
            <el-icon>
                <User />
            </el-icon>
            <side-bar-item :isCollapse="isCollapse" label="Team Members" routeName="teamMembers" />
        </el-menu-item>
        <el-menu-item index="3">
            <el-icon>
                <Document />
            </el-icon>
            <side-bar-item :isCollapse="isCollapse" label="Task Categories" routeName="categories" />
        </el-menu-item>
        <div class="p-20"></div>
    </el-scrollbar>
</template>

<script>
import {
    defineComponent,
} from "vue";
import {
    User,
    Document,
    Fold,
    Histogram,
} from "@element-plus/icons-vue";
import SideBarItem from "../Action/SideBarItem.vue";

export default defineComponent({
    props: {
        isCollapse: Boolean,
    },

    components: {
        Document,
        Fold,
        Histogram,
        User,
        SideBarItem,
    },

});
</script>
