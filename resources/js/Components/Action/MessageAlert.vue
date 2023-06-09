<template>
    <span v-if="$page.props.message != null" v-on=sweetAlert($page.props.message,$page.props.type)>
        {{ $page.props.message = null }}</span>
</template>
<script>
import Swal from 'sweetalert2'

export default {
    setup() {
        function sweetAlert(msg, type) {
            Swal.fire({
                position: 'top-center',
                icon: type ?? 'success',
                title: msg,
                showConfirmButton: false,
                timer: 2500
            })
        }
        return { sweetAlert };
    }
}
</script>
