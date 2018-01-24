<template>
  <div id="app">
    <transition enter-active-class="bounceInLeft" leave-active-class="bounceOutRight"> 
      <router-view class="animated"></router-view>
    </transition>
  </div>
</template>
<script>
export default{
  data () {
    return {
      show: false,
      transitionName: 'slide_right'
    };
  },
  watch: {
    '$route' (to, from) {
      let isBack = this.$router.isBack;
      if (isBack) {
        this.transitionName = 'slide_right';
      } else {
        this.transitionName = 'slide_left';
      }
      this.$router.isBack = false;
    }
  }
};
</script>
<style>
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
.mu-text-field-input{
  background-color: transparent!important;
}
</style>
