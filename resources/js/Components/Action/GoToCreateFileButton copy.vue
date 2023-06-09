<template>
    <Link class="float-right" :href="route(routeName)">
    <el-button type="primary" size="small">
        <h6>Add New</h6>
    </el-button>
    </Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link,
    },
    props: {
        routeName: String,
    }
}
</script>
