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
  },
  computed: {
    // 获取个人信息
    // me () {
    //   return this.$store.state.me === null ? {} : this.$store.state.me;
    // }
  },
  mounted () {
    this.welcomeUser();
  },
  async beforeRouteEnter (to, from, next) {
    console.log(from);
    if (from.name === 'login') {
      console.log('欢迎回来，');
    }
    next();
  },
  methods: {
    welcomeUser () {
      this.$alert();
    }
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
