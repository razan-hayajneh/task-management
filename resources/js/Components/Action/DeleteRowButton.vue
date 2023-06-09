<template>
    <el-icon @click="deleteRow(parameters)" style="margin-left: 10px;margin-right: 10px;" color="#F56C6C">
        <delete />
    </el-icon>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'
import { Delete } from '@element-plus/icons'
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        Link,
        Delete
    },
    props: {
        routeName: String,
        parameters: Array
    },
    setup(props) {
        function deleteRow(data) {
            data._method = "DELETE";
            Inertia.post(route(props.routeName, data.id), data);
        }
        return { deleteRow };
    }
}
</script>
