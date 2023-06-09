<template>
    <MessageAlert />
    <div>
        <el-col :span="12">
            <el-input v-model="search" size="mini" placeholder="Search" />
        </el-col>
    </div>
    <div class="table-responsive">
        <el-table stripe=true
            :data="teamMembers['data']"
            style="width: 100%">
            <el-table-column label="Photo" prop="image_url">
                <template #default="scope">
                    <img :src="scope.row.image_url" class="rounded-full h-12 w-12 object-cover" />
                </template> </el-table-column>
            <el-table-column label="Full Name" prop="full_name" />
            <el-table-column label="Phone Number" prop="phone_number" />
            <el-table-column label="Email" prop="email" />
            <el-table-column label="Member Type" prop="member_type" />
            <el-table-column label="Action" align="center">
                <template #default="scope">
                    <GoToEditFileButton routeName="teamMembers.edit" :parameters="[scope.row.id]" />
                    <DeleteRowButton routeName="teamMembers.destroy" :parameters="scope.row" />
                </template>
            </el-table-column>
        </el-table>
        <Pagination routeName="teamMembers.index" :parameters="teamMembers['meta']"  />
    </div>
</template>
<script>
import { ref } from 'vue'
import GoToEditFileButton from '../Action/GoToEditFileButton.vue'
import DeleteRowButton from '../Action/DeleteRowButton.vue'
import Pagination from '../Action/Pagination.vue'
import MessageAlert from '../Action/MessageAlert.vue'

export default {
    components: {
        GoToEditFileButton,
        DeleteRowButton,
        Pagination,
        MessageAlert,
    },
    props: {
        teamMembers: Array,
    },
    setup() {
        let search = ref('');
        return { search };
    }

}
</script>
