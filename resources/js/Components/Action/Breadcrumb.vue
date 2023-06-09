<template >
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item>
                <Link style="color: #c0b63b">{{ root }}</Link>
            </el-breadcrumb-item>
            <el-breadcrumb-item>{{ pageName }}</el-breadcrumb-item>
        </el-breadcrumb>
    </h2>
</template>

<script>
export default {
    props: {
        root: String,
        pageName: String,
    }
}
</script>
