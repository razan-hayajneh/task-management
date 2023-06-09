<template>
    <MessageAlert />
    <div>
        <el-col :span="12">
            <el-input v-model="search" size="mini" placeholder="Search" />
        </el-col>
        <GoToCreateFileButton routeName="categories.create" />
    </div>
    <div class="table-responsive">
        <el-table stripe=true
            :data="categories['data'].filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
            style="width: 100%">
            <el-table-column label="id" prop="id"> </el-table-column>
            <el-table-column label="name" prop="name"> </el-table-column>
            <el-table-column label="Action" align="center">
                <template #default="scope">
                    <GoToEditFileButton routeName="categories.edit" :parameters="[scope.row.id]" />
                    <DeleteRowButton routeName="categories.destroy" :parameters="scope.row" />
                </template>
            </el-table-column>
        </el-table>
        <Pagination routeName="categories.index" :parameters="categories['meta']" />
    </div>
</template>
<script>
import { ref } from 'vue'
import GoToCreateFileButton from '../Action/GoToCreateFileButton.vue'
import GoToEditFileButton from '../Action/GoToEditFileButton.vue'
import DeleteRowButton from '../Action/DeleteRowButton.vue'
import Pagination from '../Action/Pagination.vue'
import MessageAlert from '../Action/MessageAlert.vue'

export default {
    components: {
        GoToCreateFileButton,
        GoToEditFileButton,
        DeleteRowButton,
        Pagination,
        MessageAlert,
    },
    props: {
        categories: Array,
    },
    setup() {
        let search = ref('');
        return { search };
    }

}
</script>
