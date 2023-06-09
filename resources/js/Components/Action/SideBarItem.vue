<template>
    <Link :href="route(routeName + '.index')" :active="route().current(routeName + '.*')">
    <span v-if="isCollapse == false" class="mx-1">{{ label }}</span>
    </Link>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import { Edit } from '@element-plus/icons'

export default {
    components: {
        Link,
        Edit
    },
    props: {
        label: String,
        routeName: String,
        isCollapse: Boolean
    }
}
</script>
