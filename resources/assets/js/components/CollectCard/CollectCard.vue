<template>
  <mu-flexbox @click.native="$router.push({name: 'collection'})" class="collect_card" orient="vertical">
    <mu-flexbox-item class="collect_top">
      <img src="../../assets/images/bg.png" alt="">
    </mu-flexbox-item>
    <mu-flexbox-item class="my_photo">
      <img src="../../assets/images/temp.jpg" alt="">
    </mu-flexbox-item>
    <mu-flexbox-item class="collect_bottom">
      <strong>山崎贤人</strong>
      <p>私密分享</p>
      <p>没有关注者</p>
    </mu-flexbox-item>
  </mu-flexbox>
</template>
<script>
export default{
  methods: {
    // path () {
    //   this.$router.push({name: 'collection'});
    // }
  }
};
</script>
<style lang="less">
.collect_card{
  height: 280px;
  background: #ddd; 
  position: relative;
  min-width: 150px;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.2);
  .collect_top{
    height: 50%;
  }
  .collect_top>img{
    width: 100%;
    height: 100%;
  }
  .my_photo{
    position: absolute;
    width: 50px;
    height: 50px;
    overflow: hidden;
    top: 45%;
    left: 20px;
    transform: translateY(-50%);
    border-radius: 50%;
    border: 2px solid #fff;
    &>img{
      width: 100%;
      height: 100%;
    }
  }
  .collect_bottom{
    height: 50%;
    padding: 30px 20px;
    background: #778F9B;
    margin-top: -8px!important;
    &>strong{
      color: #fff;
      font-size: 17px;
      font-weight: normal;
    }
    &>p{
      color: #ccc;
    }
  }
}
</style>
