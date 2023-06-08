<template>
    <app-layout title="Edit System">

        <template #titleHeader>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <el-breadcrumb separator="/" v-if="$page.props.locale == 'en'">
                    <el-breadcrumb-item>
                        <Link style="color: #c0b63b">Materials</Link>
                    </el-breadcrumb-item>
                    <el-breadcrumb-item>Update</el-breadcrumb-item>
                </el-breadcrumb>
            </h2>
        </template>
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
            <el-card class="box-card">
                <FieldsForm :category="category" type="Update"></FieldsForm>
            </el-card>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import FieldsForm from '@/Components/Category/FieldsForm.vue'
export default ({
    components: {
        AppLayout,
        Head,
        Link,
        FieldsForm
    },
    props: {
        category: Object
    },
})

</script>
