<template>
    <div class="page-wrap">
        <Page :total="total" show-elevator show-total @on-change="handleChange"></Page>
        <div style="clear: both;"></div>
    </div>
</template>
<script>
    export default {
        props:['total'],
        methods: {
            handleChange(page) {
                this.$emit('on-change',page)
            }
        }
    }
</script>