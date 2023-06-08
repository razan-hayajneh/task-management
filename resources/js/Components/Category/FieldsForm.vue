
<template>
    <el-form ref="formData" :model="ruleForm" :rules="rules" label-width="120px" label-position="left"
        class="demo-ruleForm mx-12">
        <el-row>
            <el-form-item label="Name" prop="name">
                <el-input v-model="ruleForm.name"></el-input>
                <div style="color: red; font-size: 0.75rem">
                    {{ $page.props.errors.name }}
                </div>
            </el-form-item>
        </el-row>
        <el-form-item>
            <el-button class="button" type="primary" @click="submitForm" style="background-color: #5a5858; color: #ffffff"
                v-if="type == 'Create'">{{ __('crud.save') }} </el-button>
            <el-button type="primary" @click="submitForm" style="background-color: #5a5858; color: #ffffff"
                v-if="type == 'Update'">{{ __('crud.edit') }} </el-button>

            <el-button @click="onCancel">{{ __("crud.cancel") }}</el-button>

        </el-form-item>

    </el-form>
</template>
<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { reactive } from "vue";
import { ElMessage } from "element-plus";
export default {
    components: {
        Head,
        Link,
        ElMessage,
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
        console.log(props.type);
        const rules = reactive({
            name: [
                {
                    required: true,
                    message: 'Name is Required',
                    trigger: "blur",
                },
            ],
        });
        function submitForm() {
            if (props.type == "Update") {
                ruleForm._method = "PUT";
            }
            console.log(ruleForm);

            props.type == "Update"
                ? Inertia.post(route("categories.update", ruleForm.id), ruleForm)
                : Inertia.post(route("categories.store"), ruleForm);
        }
        function onCancel() {
            Inertia.get(route("categories.index"));
        }
        function onError() {
            ElMessage({
                showClose: true,
                message: "Oops, this is an error message.",
                type: "error",
            });
        }
        return {
            ruleForm,
            rules,
            submitForm,
            onCancel,
            onError,
        };
    },
};
</script>
<style>
.el-input {
    width: 170px;
}

.el-input:lang(ar) {
    width: 170px;
}

.el-button:lang(ar) {
    margin: 10px;
}
</style>
