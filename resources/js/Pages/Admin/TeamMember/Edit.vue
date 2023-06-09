<template>
    <app-layout title="Edit Team Member">
        <template #titleHeader>
            <Breadcrumb root="TeamMembers" pageName="Update" />
        </template>
        <div class="py-2 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden">
            <el-card class="box-card">
                <FieldsForm :teamMember="teamMember['data']" type="Update" />
            </el-card>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Breadcrumb from '@/Components/Action/Breadcrumb.vue'
import FieldsForm from '@/Components/TeamMember/FieldsForm.vue'
export default ({
    components: {
        AppLayout,
        Breadcrumb,
        FieldsForm,
    },
    props: {
        teamMember: Array
    },
})

</script>
