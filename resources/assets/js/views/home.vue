<template>
  <div class="home clear_fixed">
    <top-nav></top-nav>
    <mu-flexbox class="item" align="flex-start" justify="flex-start">
      <mu-flexbox-item class="flex-demo">
        <menu-bar></menu-bar>
      </mu-flexbox-item>
      <mu-flexbox-item class="item_inner">
        <router-view></router-view>
      </mu-flexbox-item>
    </mu-flexbox>
    <article-create-panel></article-create-panel>
    <article-card :closeable="true"></article-card>
  </div>
</template>
<script>
import TopNav from '../components/TopNav/TopNav.vue';
// 左侧菜单组件
import MenuBar from '../components/MenuBar/MenuBar.vue';
import {ArticleCreatePanel} from '../components/ArticleCreate';
import ArticleCard from '../components/ArticleCard/ArticleCard.vue';
export default{
  components: {
    TopNav,
    MenuBar,
    ArticleCreatePanel,
    ArticleCard
  },
  data () {
    return {
      // isMenu: null
    };
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    },
    menu () {
      return this.$children[0];
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
  padding: 15px;
  height: calc(~"100% - 80px");
}
.item_inner{
  height: 100%;
  overflow: auto;
  padding: 10px;
  flex: 5 auto!important;
}
.active_menu{
  flex: 0 0 auto;
}
</style>
