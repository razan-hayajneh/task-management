<template>
    <el-button @click="submitForm" class="submitForm">Update</el-button>
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
            props.ruleForm._method = "PUT";
            Inertia.post(route(props.routeName, props.ruleForm.id), props.ruleForm);
        }
        return { submitForm };
    }
}
</script>
