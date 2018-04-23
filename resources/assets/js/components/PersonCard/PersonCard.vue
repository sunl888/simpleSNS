<template>
  <mu-paper class="person-card">
      <img src="../../assets/images/temp.jpg" alt="">
      <h3>asdsadsadas</h3>
      <mu-flat-button>已关注</mu-flat-button>
  </mu-paper>
</template>
<script>
export default {
};
</script>
<style lang="less">
  .person-card{
    width: 50%;
    max-width: 230px;
    padding: 0 0 5px;
    overflow: hidden;
    margin: 10px;
    float: left;
    img{
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin: 30px auto 20px;
      display: block;
    }
    h3{
      text-align: center;
    }
    .mu-flat-button{
      margin: 10px auto;
      display: block;
    }
  }
</style>

