<template>
    <el-button @click="submitForm" class="submitForm">Save</el-button>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'

export default {
    props: {
        routeName: String,
        ruleForm: Array
    },
    setup(props) {
        function submitForm() {
            Inertia.post(route(props.routeName), props.ruleForm);
        }
        return { submitForm };
    }
}
</script>
