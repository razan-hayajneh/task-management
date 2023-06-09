<template>
            <el-scrollbar class="mb-5">
                <Link :href="route('dashboard')" :active="route().current('dashboard')">
                <el-menu-item index="0">
                    <el-icon>
                        <histogram />
                    </el-icon>
                    <span v-if="isCollapse == false" class="mx-1">Dashboard</span>
                </el-menu-item> </Link>
                <Link :href="route('admins.index')" :active="route().current('admins.*')">
                <el-menu-item index="1">
                    <el-icon>
                        <User />
                    </el-icon>
                    <span v-if="isCollapse == false" class="mx-1">Admins</span>
                </el-menu-item> </Link>
                <Link :href="route('categories.index')" :active="route().current('categories.*')">
                <el-menu-item index="2">
                    <el-icon>
                        <Document />
                    </el-icon>
                    <span v-if="isCollapse == false" class="mx-1">Task Categories</span>
                </el-menu-item> </Link>
                <div class="p-20"></div>
            </el-scrollbar>
</template>

<script>
import {
    defineComponent,
    ref
} from "vue";
import {
    User,
    Document,
    Menu as IconMenu,
    Fold,
    Histogram,
} from "@element-plus/icons-vue";

export default defineComponent({
    props: {
        isCollapse: Boolean,
    },

    components: {
        Document,
        IconMenu,
        Fold,
        Histogram,
        User,
    },

    data() {
        const pages = {
            "Admin/Dashboard": "0",
            "Admin/Admin": "1",
            "Admin/Category": "2",
        };
        let component = ref("0");
        for (var key in pages) {
            if (this.$page.component.includes(key)) component = pages[key];
        }
        const active = ref(component);
        return {
            active,
        };
    },

});
</script>
