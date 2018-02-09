<template>
<div>
  <mu-flexbox v-if="isFind === true" class="find" :gutter="40" align="stretch" justify="center">
    <mu-flexbox-item style="width: 100%">
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
    <mu-flexbox-item style="width: 100%" v-if="this.column > 1" >
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
    <mu-flexbox-item style="width: 100%" v-if="this.column > 2" >
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
    <mu-flexbox-item v-if="this.column > 3" style="width: 100%">
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
  </mu-flexbox>
  <mu-flexbox class="find" :gutter="50" align="stretch" justify="center">
    <mu-flexbox-item>
      <p>我的收藏集</p>
      <collect-card :value="value.id"  :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color" v-for="(value, index) in cols.col1" :key="index"></collect-card>
    </mu-flexbox-item>
    <mu-flexbox-item v-if="column > 1" >
      <collect-card :value="value.id"  :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color" v-for="(value, index) in cols.col2" :key="index"></collect-card>
    </mu-flexbox-item>
    <mu-flexbox-item v-if="column > 2" >
      <collect-card :value="value.id" :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color" v-for="(value, index)  in cols.col3" :key="index"></collect-card>
    </mu-flexbox-item>
    <!-- <mu-flexbox-item v-if="this.column > 3" style="width: 100%">
      <collect-card v-for="x in 5" :key="x"></collect-card>
    </mu-flexbox-item> -->
  </mu-flexbox>
</div>
</template>
<script>
import FindTinyCard from '../components/FindTinyCard/FindTinyCard.vue';
import {CollectCard} from '../components/CollectCard';
export default{
  components: {
    FindTinyCard,
    CollectCard
  },
  data () {
    return {
      me: [],
      // 当前窗口宽度
      winSize: window.screen.width,
      // 根据当前分辨率判断显示几列内容
      column: this.winSize > 1023 ? 3 : (this.winSize > 600 ? 2 : 1),
      // 文章列表
      item: [],
      // 是否显示写文章
      isCreatePanel: false,
      // 文章分栏
      cols: {},
      isFind: true
    };
  },
  watch: {
    '$route' () {
      this.isFind = this.$route.name === 'find';
    }
  },
  mounted () {
    this.me = this.$store.state.me === null ? null : this.$store.state.me;
    this.isFind = this.$route.name === 'find';
    this.getItem();
    this.handleResize();
    window.addEventListener('resize', this.handleResize);
  },
  methods: {
    // 监听分辨率分栏
    handleResize () {
      this.winSize = document.documentElement.clientWidth;
      this.column = this.winSize > 1023 ? 3 : (this.winSize > 600 ? 2 : 1);
      this.cols = {};
      if (this.column === 1) {
        this.cols.col1 = this.item;
      } else if (this.column === 2) {
        this.cols.col1 = this.item.slice(0, this.item.length / 2 + 1);
        this.cols.col2 = this.item.slice(this.item.length / 2 + 1);
      } else {
        this.cols.col1 = this.item.slice(0, this.item.length / 3 + 1);
        this.cols.col2 = this.item.slice(this.cols.col1.length, this.item.length / 3 * 2 + 1);
        this.cols.col3 = this.item.slice(this.item.length / 3 * 2 + 1);
      }
    },
    // 获取文章
    getItem () {
      this.item = this.me.collections.data;
      console.log(this.me);
      // let url = this.isFind === 'find' ? 'collections' : 'collections';
    }
  }
};
</script>
<style lang="less">
</style>
