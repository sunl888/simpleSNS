<template>
  <div class="home">
    <top-nav></top-nav>
    <menu-bar></menu-bar>
    <router-view></router-view>
  </div>
</template>
<script>
import TopNav from '../components/TopNav/TopNav.vue';
// 左侧菜单组件
import MenuBar from '../components/MenuBar/MenuBar.vue';
export default{
  components: {
    TopNav,
    MenuBar
  },
  computed: {
    // 获取个人信息
    // me () {
    //   return this.$store.state.me === null ? {} : this.$store.state.me;
    // }
  },
  watch: {
    '$route' (to, from) {
      console.log(123);
    }
  },
  mounted () {
    console.log(this.$route);
  },
  methods: {
    welcomeUser () {
      this.$alert();
    }
  }
};
</script>
<style lang="less">
*{
  margin: 0;
  padding: 0;
}
.home{
  width: 100%;
  height: 100%;
  background: #f1f1f1;
}
</style>
