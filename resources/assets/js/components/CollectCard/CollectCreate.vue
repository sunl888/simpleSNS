<template>
  <mu-flexbox class="collect_card create" orient="vertical" justify="center" align="center">
    <mu-flexbox-item class="collect_top">
      <i class="material-icons">add_circle_outline</i>
      <p>创建收藏集</p>
    </mu-flexbox-item>
  </mu-flexbox>
</template>
<script>
export default{
};
</script>
<style lang="less">
.create{
  background: #fff!important;
  &>.collect_top{
    padding: 100px 0;
    &>i{
      margin: 0 auto;
      display: block;
      font-size: 50px;
      color: #666;
    }
    &>p{
      color: #666;
      font-size: 18px;
      margin-top: 10px;
      display: block;
      text-align: center;
    }
  }
}
</style>
