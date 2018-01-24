<template>
  <div class="home">
    <top-nav></top-nav>
    <router-view></router-view>
  </div>
</template>
<script>
import TopNav from '../components/TopNav/TopNav.vue';
export default{
  components: {
    TopNav
  }
};
</script>
<style scoped>
*{
  margin: 0;
  padding: 0;
}
.home{
  width: 100%;
  height: 100%;
  background: #f1f1f1;
}
.clear_fixed:after{
  content: "";
  clear: both;
  display: block;
}
</style>
