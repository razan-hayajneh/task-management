<template>
    <Link :href="route(routeName, parameters)" class='btn btn-default btn-xs mx-3'>
    <el-icon color="#67C23A">
        <edit />
    </el-icon>
    </Link>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import { Edit} from '@element-plus/icons'

export default {
    components: {
        Link,
        Edit
    },
    props: {
        routeName: String,
        parameters: Array
    }
}
</script>
