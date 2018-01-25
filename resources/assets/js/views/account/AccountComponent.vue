<template>
<div class="login_box">
  <transition enter-active-class="bounceInLeft" leave-active-class="bounceOutRight"> 
    <router-view class="animated"></router-view>
  </transition>
</div>
</template>
<script>
export default{
  data () {
    return {
      // 用户id
      userId: null,
      // 用户密码
      userPassword: null
    };
  }
};
</script>
<style lang="less">
.login_box{
  width: 100%;
  height: 100%;
  background: url(../../assets/images/01.jpg);
  background-size: cover;
  background-attachment: fixed;
}
.login{
  width: 100%;
  min-height: 80%;
  padding: 18px 0;
  background: rgba(255, 255, 255, 0.9)!important;
  position: absolute;
  bottom: 0;
  // transform: translateY(-50%);
  box-shadow: 2px 0px 10px 1px #444;
  .photo{
    @size: 150px;
    width: @size;
    height: @size;
    border-radius: 50%;
    border: 5px solid #fff;
    overflow: hidden;
    position: absolute;
    left: 50%;
    top: -75px;
    transform: translateX(-50%);
    img{
      width: 100%;
      height: 100%;
    }
  }
  .form{
    margin: 0 auto;
    overflow: hidden;
    padding: 0 20px;
    h2{
      margin: 60px 0 20px 0; 
      text-align: center;
    }
    .submit_btn{
      width: calc(~"100% - 17px");
      margin: 20px 17px;
    }
  }
}
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active for below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
</style>
