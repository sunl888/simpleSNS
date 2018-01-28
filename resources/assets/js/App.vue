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
    };
  },
  mounted () {
    if (isLogin()) {
      this.$store.dispatch('updateMe');
    }
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
@media (min-width: 993px) {
  @MenuBar: 20%;
  .menu_bar{
    width: @MenuBar;
  }
}
@media (max-width: 600px) {
  @MenuBar: 100%;
  .menu_bar{
    width: @MenuBar;
  }
}
</style>
