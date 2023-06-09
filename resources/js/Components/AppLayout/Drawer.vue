<template>
    <div>
        <ul>
            <el-row class="font-bold text-color icon-school inline-flex">
                <el-col :span="2"> <el-icon>
                        <histogram />
                    </el-icon></el-col>
                <h3>
                    <Link :href="route('dashboard')" :active="route().current('dashboard')">
                    <span class="mx-1">Dashboard</span>
                    </Link>
                </h3>
            </el-row>
            <HorizontalLine />
            <el-row class="font-bold text-color icon-school inline-flex">
                <el-col :span="2"> <el-icon>
                        <UserFilled />
                    </el-icon></el-col>
                <h3>
                    <DrawerItem label="Admins" routeName="admins" />
                </h3>
            </el-row>
            <HorizontalLine />
            <el-row class="font-bold text-color icon-school inline-flex">
                <el-col :span="2">
                    <el-icon>
                        <UserFilled />
                    </el-icon>
                </el-col>
                <h3>
                    <DrawerItem label="Team Members" routeName="teamMembers" />
                </h3>
            </el-row>
            <HorizontalLine />
            <el-row class="font-bold text-color icon-school inline-flex">
                <el-col :span="2">
                    <el-icon>
                        <Document />
                    </el-icon>
                </el-col>
                <h3>
                    <DrawerItem label="Categories" routeName="categories" />
                </h3>
            </el-row>
            <HorizontalLine />
        </ul>
        <HorizontalLine />
    </div>
</template>

<script>
import {
    defineComponent,
    ref
} from "vue";

import {
    User,
    UserFilled,
    Document,
    Histogram,
} from "@element-plus/icons-vue";
import HorizontalLine from "../Action/HorizontalLine.vue";
import DrawerItem from "../Action/DrawerItem.vue";

export default defineComponent({
    props: {
        isCollapse: Boolean,
    },

    components: {
        Document,
        Histogram,
        User,
        UserFilled,
        HorizontalLine,
        DrawerItem,
    },


});
</script>
