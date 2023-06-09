
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
            <el-form-item label="Member Type" prop="member_type">
                <el-input v-model="ruleForm.member_type"></el-input>
                <ValidationError :error="$page.props.errors.member_type" />
            </el-form-item>
            <el-form-item label="Password" prop="password">
                <el-input type="password" v-model="ruleForm.password"></el-input>
                <ValidationError :error="$page.props.errors.password" />
            </el-form-item>
        </el-row>
        <dev>
            <UpdateButton routeName="teamMembers.update" :ruleForm="ruleForm" />
            <CancelButton routeName="teamMembers.index" />
        </dev>

    </el-form>
</template>
<script>
import { reactive } from "vue";
import CancelButton from '../Action/CancelButton.vue';
import UpdateButton from '../Action/UpdateButton.vue';
import ValidationError from '../Action/ValidationError.vue';
export default {
    components: {
        CancelButton,
        UpdateButton,
        ValidationError,
    },
    props: {
        teamMember: Array
    },
    setup(props) {
        let ruleForm = reactive({
            id: props.teamMember != null ? props.teamMember.id : null,
            full_name: props.teamMember != null ? props.teamMember.full_name : null,
            email: props.teamMember != null ? props.teamMember.email : null,
            phone_number: props.teamMember != null ? props.teamMember.phone_number : null,
            member_type: props.teamMember != null ? props.teamMember.member_type : null,
            image_url: props.teamMember != null ? props.teamMember.image_url : null,
        });
        return {
            ruleForm,
        };
    },
};
</script>
