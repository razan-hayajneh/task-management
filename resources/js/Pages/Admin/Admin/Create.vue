<template>
    <app-layout title="Create Admin">
        <template #titleHeader>
            <Breadcrumb root="Admins" pageName="Add" />
        </template>
        <div class="py-2 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden">
            <el-card class="box-card">
                <FieldsForm :type='create' />
            </el-card>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import FieldsForm from '@/Components/Admin/FieldsForm.vue'
import Breadcrumb from '@/Components/Action/Breadcrumb.vue'

export default ({
    components: {
        AppLayout,
        FieldsForm,
        Breadcrumb,
    },
})
</script>
