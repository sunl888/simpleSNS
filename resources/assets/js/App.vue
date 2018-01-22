<template>
  <div>
    <top-nav></top-nav>
  </div>
</template>
<script>
import TopNav from './components/TopNav/TopNav.vue'
export default{
  components: {
    TopNav
  }
}
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
</style>
