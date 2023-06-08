<template>
    <span v-if="$page.props.message != null" v-on=sweetAlert($page.props.message,$page.props.type)>{{ $page.props.message = null }}</span>

    <div>
        <el-col :span="12">
            <el-input v-model="search" size="mini" :placeholder="__('auth.app.search')" />
        </el-col>
        <Link class="float-right" :href="route('categories.create')">
        <el-button type="primary" size="small">
            <h6>{{ __('crud.add_new_material') }}</h6>
        </el-button>
        </Link>
    </div>
    <div class="table-responsive">
        <el-table stripe=true
            :data="categories.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
            style="width: 100%">
            <el-table-column label="id" prop="id"> </el-table-column>
            <el-table-column label="name" prop="name"> </el-table-column>
            <el-table-column label="Action" align="center">
                <template #default="scope">
                    <Link :href="route('categories.edit', [scope.row.id])" class='btn btn-default btn-xs mx-3'>
                    <el-icon color="#67C23A">
                        <edit />
                    </el-icon>
                    </Link>
                    <el-icon @click="deleteRow(scope.row)" style="margin-left: 10px;margin-right: 10px;" color="#F56C6C">
                        <delete />
                    </el-icon>
                </template>
            </el-table-column>
        </el-table>
    </div>
    <el-pagination background :total="total" layout="prev, pager, next" @current-change="loadMorePagin"
        :current-page="currentPage"> </el-pagination>
</template>
<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { Edit, View, Delete, Plus } from '@element-plus/icons'
import { ref } from 'vue'
import Swal from 'sweetalert2'

export default {
    components: {
        Head,
        Link,
        Edit,
        View,
        Delete,
        Plus
    },
    props: {
        categories: Array,
        page: String,
        countRow: String,
    },
    setup(props) {
        let search = ref('');
        let currentPage = ref(parseInt(props.page));
        let total = ref(parseInt(props.countRow));
        function loadMorePagin(value) {
            console.log(value);
            Inertia.get(route('categories.index', props.categories['id']), value);
        }
        function deleteRow(data) {
            data._method = "DELETE";
            data.password = result.value.password;
            Inertia.post(route('categories.destroy', data.id), data);
        }
        function alertMessage(message) {
            ElMessage({
                showClose: true,
                message: message,
                type: 'success',
            })
        }
        function sweetAlert(msg, type) {
            Swal.fire({
                position: 'top-center',
                icon: type??'success',
                title: msg,
                showConfirmButton: false,
                timer: 2500
            })
        }
        return { search, total, deleteRow, alertMessage, currentPage, loadMorePagin, sweetAlert };
    }

}
</script>


<style >
.el-table .el-table__cell {
    padding: 12px 2px;
    min-width: 0;
    box-sizing: border-box;
    text-overflow: ellipsis;
    vertical-align: middle;
    position: relative;
    text-align: left;
}

.el-table .el-table__cell:lang(ar) {
    text-align: right;
}</style>
