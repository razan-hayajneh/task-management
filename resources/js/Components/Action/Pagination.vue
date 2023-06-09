<template>
    <el-pagination background layout="prev, pager, next" @current-change="loadMorePaginate"
        :total="parameters['total']" :current-page="parameters['current_page']"> </el-pagination>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'

export default {
    props: {
        routeName: String,
        parameters: Array
    },
    setup(props) {
        function loadMorePaginate(value) {
            console.log('aaa',value);
            Inertia.get(route(props.routeName), { page: value });
        }
        return { loadMorePaginate };
    }
}
</script>
