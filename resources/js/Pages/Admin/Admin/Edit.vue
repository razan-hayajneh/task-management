<template>
    <app-layout title="Edit Admin">
        <template #titleHeader>
            <Breadcrumb root="Categories" pageName="Update" />
        </template>
        <div class="py-2 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden">
            <el-card class="box-card">
                <FieldsForm :admin="admin['data']" type="Update" />
            </el-card>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Breadcrumb from '@/Components/Action/Breadcrumb.vue'
import FieldsForm from '@/Components/Admin/FieldsForm.vue'
export default ({
    components: {
        AppLayout,
        Breadcrumb,
        FieldsForm,
    },
    props: {
        admin: Array
    },
})

</script>
