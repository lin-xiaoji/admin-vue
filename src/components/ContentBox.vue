<template>
    <div class="content-box">
        <div class="content-box-hd">{{header}}</div>
        <div class="content-box-bd">
            <div><slot></slot></div>
        </div>
    </div>
</template>

<style>

    .content-box {
        background-color: #fff;
        border-top: solid 4px #e7eaec;
        margin: 15px 20px 20px 15px;

    }
    .content-box-hd {
        border-bottom: solid 1px #e3e3e3;
        height: 40px;
        line-height: 40px;
        padding-left: 20px;
        font-size: 14px;
        font-weight: bold;
    }

    .content-box-bd{
        padding: 15px 20px 20px;
    }
</style>
<script>
    export default {
        props:['header'],
    }
</script>