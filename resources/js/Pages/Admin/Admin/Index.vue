<template>
    <app-layout title="Admins">
        <template #titleHeader>
            <Breadcrumb root="Admins" pageName="Details" />
        </template>
        <div class="py-2 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden">
            <el-card class="box-card" style="width:100%">
                <DataTable :admins='admins'></DataTable>
            </el-card>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from '@/Components/Action/Breadcrumb.vue'
import DataTable from "@/Components/Admin/DataTable.vue";

export default {
    components: {
        AppLayout,
        Breadcrumb,
        DataTable,
    },
    props: {
        admins: Array
    }
};
</script>

