<template>
    <div>
        <ul>
            <el-row class="font-bold text-color icon-school inline-flex">
                <el-col :span="2"> <el-icon>
                        <histogram />
                    </el-icon></el-col>
                <h3>
                    <Link :href="route('dashboard')" :active="route().current('dashboard')">
                    <span class="mx-1">
                        {{ __("auth.app.dashboard") }}</span>
                    </Link>
                </h3>
            </el-row>
            <hr style="
                width: 100%;
                text-align: left;
                margin-left: 0;
                padding: 0.5rem;
            " />
            <el-row class="font-bold text-color icon-school inline-flex">
                <Link :href="route('admins.index')" :active="route().current('admins.*')">
                <el-col :span="2"> <el-icon>
                        <UserFilled />
                    </el-icon></el-col>
                <h3>
                    <span class="mx-1">
                        {{ __("auth.app.dashboard") }}</span>

                </h3>
                </Link>
            </el-row>
            <hr style="
                width: 100%;
                text-align: left;
                margin-left: 0;
                padding: 0.5rem;
            " />
        </ul>
        <hr style="width: 100%; text-align: left; margin-left: 0; padding: 0.5rem" />
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
        UserFilled
    },


});
</script>
