<template>
  <div id="app">
    <transition enter-active-class="bounceInLeft" leave-active-class="bounceOutRight"> 
      <router-view class="animated"></router-view>
    </transition>
  </div>
</template>
<script>
import { isLogin } from './utils/utils';
export default{
  data () {
    return {
      winSize: window.screen.width
    };
  },
  mounted () {
    if (isLogin()) {
      this.$store.dispatch('updateMe');
    }
  },
  methods: {
  }
};
</script>
<style lang="less">
*{
  margin: 0;
  padding: 0;
}
html, body, #app{
  width: 100%;
  height: 100%;
}
.clear_fixed:after{
  content: "";
  clear: both;
  display: block;
}
.file-button{
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  opacity: 0;
}
.theme_btn{
  margin-top: 5px;
  display: block;
  width: 70px;
  padding: 2px 0;
  text-align: center;
  background: #4d90fe;
  border: 1px solid #3079ed;
  color:#fff;
  font-size: 12px;
  border-radius: 2px;
  line-height: 20px;
  &:hover{
    background: #3884fd;
  }
}
 .mu-flat-button.uploadEle{
  position: absolute;
  top: 180px;
  right: 20px;
  border-radius: 50%;
  width: 50px;
  min-width: 50px;
  height: 50px;
  color: #fff;
  background: rgba(0, 0, 0, 0.3);
}
</style>
