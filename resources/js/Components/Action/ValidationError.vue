<template>
    <div style="color: red; font-size: 0.75rem">
        {{ error }}
    </div>
</template>

<script>
export default {
    props: {
        error: String,
    }
}
</script>
