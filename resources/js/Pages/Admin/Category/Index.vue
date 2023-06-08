<template>
    <app-layout title="Admin">
        <template #titleHeader>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item>
                        <Link style="color: #c0b63b">Categories</Link>
                    </el-breadcrumb-item>
                    <el-breadcrumb-item>{{ __("crud.detail") }}</el-breadcrumb-item>
                </el-breadcrumb>
            </h2>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden">
                    <div>
                        <el-card class="box-card" style="width:100%">
                            <DataTable :categories='categories' :page='page' :countRow='countRow'></DataTable>
                        </el-card>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import DataTable from "@/Components/Category/DataTable.vue";
import { ElMessage } from "element-plus";

export default {
    components: {
        AppLayout,
        Welcome,
        DataTable,
        ElMessage
    },
    props: {
        categories: Array,
        page: String,
        countRow: String,
    },
    setup(props) {

        function alertMessage(message) {
            ElMessage({
                showClose: true,
                message: message,
                type: 'success',
            })
        }
        return { alertMessage };
    }
};
</script>

<style>
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.text {
    font-size: 14px;
}

.item {
    margin-bottom: 18px;
}

.demo-progress .el-progress--line {
    display: inline-block;
    margin-bottom: 15px;
    width: 100px;
}

.demo-progress .el-progress--circle {
    margin-right: 15px;
    display: inline-flex;

}
</style>
