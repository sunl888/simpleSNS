<template>
  <div id="app">
    <transition :name="transitionName"> 
      <router-view></router-view>
    </transition>
  </div>
</template>
<script>
export default{
  data () {
    return {
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
body{
  background: #f1f1f1;
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
