<template>
  <div class="home clear_fixed">
    <top-nav></top-nav>
    <mu-flexbox class="item" align="flex-start" justify="flex-start">
      <mu-flexbox-item v-if="isMenu" class="flex-demo">
        <menu-bar v-on:closeMenu="isMenu = false" :showMenu="isMenu" :menuStyle="menuVer"></menu-bar>
      </mu-flexbox-item>
      <mu-flexbox-item class="item_inner" :class="{'active_menu' : isMenu === false}">
        <router-view></router-view>
      </mu-flexbox-item>
    </mu-flexbox>
    <article-card :closeable="true"></article-card>
  </div>
</template>
<script>
import TopNav from '../components/TopNav/TopNav.vue';
// 左侧菜单组件
import MenuBar from '../components/MenuBar/MenuBar.vue';
import ArticleCard from '../components/ArticleCard/ArticleCard.vue';
export default{
  components: {
    TopNav,
    MenuBar,
    ArticleCard
  },
  data () {
    return {
      isMenu: false,
      menuVer: 'big',
      winSize: window.screen.width
    };
  },
  watch: {
    '$route' () {
      this.handleResize();
    }
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
  mounted () {
    this.handleResize();
    window.addEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize () {
      this.winSize = document.documentElement.clientWidth;
      if (this.winSize < 900 || this.$route.name === 'collection') {
        this.menuVer = 'mobile';
        this.isMenu = false;
      } else {
        this.menuVer = 'big';
        this.isMenu = true;
      }
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
  overflow: hidden;
  background: #f1f1f1;
}
.item{
  height: calc(~"100% - 70px");
}
.item_inner{
  height: 100%;
  overflow: auto;
  padding: 20px;
  transition: padding 0.3s;
  align-items: center;
  flex: 5 auto!important;
}
.active_menu{
  padding: 20px 5%;
}
</style>
