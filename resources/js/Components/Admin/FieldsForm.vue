
<template>
    <el-form ref="formData" :model="ruleForm" label-width="120px" label-position="left" class="demo-ruleForm mx-12">
        <el-row>
            <el-form-item label="Name" prop="full_name">
                <el-input v-model="ruleForm.full_name"></el-input>
                <ValidationError :error="$page.props.errors.full_name" />
            </el-form-item>
            <el-form-item label="Email" prop="email">
                <el-input v-model="ruleForm.email"></el-input>
                <ValidationError :error="$page.props.errors.email" />
            </el-form-item>
            <el-form-item label="Phone Number" prop="phone_number">
                <el-input v-model="ruleForm.phone_number"></el-input>
                <ValidationError :error="$page.props.errors.phone_number" />
            </el-form-item>
            <el-form-item label="Access Level" prop="access_level">
                <el-input v-model="ruleForm.access_level"></el-input>
                <ValidationError :error="$page.props.errors.access_level" />
            </el-form-item>
            <el-form-item label="Password" prop="password">
                <el-input type="password" v-model="ruleForm.password"></el-input>
                <ValidationError :error="$page.props.errors.password" />
            </el-form-item>
        </el-row>
        <dev>
            <UpdateButton v-if="type == 'Update'" routeName="admins.update" :ruleForm="ruleForm" />
            <create-button v-else routeName="admins.store" :ruleForm="ruleForm" />
            <CancelButton routeName="admins.index" />
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
        admin: Array,
        type: {
            Type: String,
            default: "Create",
        },
    },
    setup(props) {
        let ruleForm = reactive({
            id: props.admin != null ? props.admin.id : null,
            full_name: props.admin != null ? props.admin.full_name : null,
            email: props.admin != null ? props.admin.email : null,
            phone_number: props.admin != null ? props.admin.phone_number : null,
            access_level: props.admin != null ? props.admin.access_level : null,
            image_url: props.admin != null ? props.admin.image_url : null,
        });
        return {
            ruleForm,
        };
    },
};
</script>
