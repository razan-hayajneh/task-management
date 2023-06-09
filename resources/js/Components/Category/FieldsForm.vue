
<template>
    <el-form ref="formData" :model="ruleForm" :rules="rules" label-width="120px" label-position="left"
        class="demo-ruleForm mx-12">
        <el-row>
            <el-form-item label="Name" prop="name">
                <el-input v-model="ruleForm.name"></el-input>
                <ValidationError :error="$page.props.errors.name"/>
            </el-form-item>
        </el-row>
        <dev>
            <UpdateButton v-if="type == 'Update'" routeName="categories.update" :ruleForm="ruleForm" />
            <create-button v-else routeName="categories.store" :ruleForm="ruleForm" />
            <CancelButton routeName="categories.index" />
        </dev>

    </el-form>
</template>
<script>
import { reactive } from "vue";
import CancelButton from '../Action/CancelButton.vue';
import UpdateButton from '../Action/UpdateButton.vue';
import CreateButton from '../Action/CreateButton.vue';
import ValidationError from '../Action/ValidationError.vue';
export default {
    components: {
        CancelButton,
        UpdateButton,
        CreateButton,
        ValidationError,
    },
    props: {
        category: Array,
        type: {
            Type: String,
            default: "Create",
        },
    },
    setup(props) {
        let ruleForm = reactive({
            name: props.category != null ? props.category.name : null,
            id: props.category != null ? props.category.id : null,
        });
        return {
            ruleForm,
        };
    },
};
</script>
