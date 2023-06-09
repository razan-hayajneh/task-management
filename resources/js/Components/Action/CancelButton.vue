<template>
    <el-button @click="onCancel" class="inline-flex">Cancel</el-button>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'

export default {
    props: {
        routeName: String,
    },
    setup(props) {
        function onCancel() {
            Inertia.get(route(props.routeName));
        }
        return { onCancel };
    }
}
</script>
