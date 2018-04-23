<template>
<div>
  <p>我的收藏集</p>
  <mu-flexbox class="find" :gutter="40" align="stretch" justify="center">
    <mu-flexbox-item style="width: 100%">
      <collect-card v-for="(value, index) in cols.col1"  :key="index"  :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color" :value="value.id" :isSubscribe="value.is_author"></collect-card>
    </mu-flexbox-item>
    <mu-flexbox-item style="width: 100%" v-if="this.column > 1" >
      <collect-card  v-for="(value, index) in cols.col2"  :key="index" :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color" :value="value.id" :isSubscribe="value.is_author"></collect-card>
    </mu-flexbox-item>
    <mu-flexbox-item style="width: 100%" v-if="this.column > 2" >
      <collect-card v-for="(value, index) in cols.col3"  :key="index" :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color" :value="value.id" :isSubscribe="value.is_author"></collect-card>
    </mu-flexbox-item>
  </mu-flexbox>
</div>
</template>
<script>
import {CollectCard} from '../components/CollectCard';
export default{
  components: {
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
      isFind: true,
      collectionList: []
    };
  },
  watch: {
    '$route' () {
      this.isFind = this.$route.name === 'find';
    }
  },
  async mounted () {
    this.getCollections();
    this.me = this.$store.state.me === null ? null : this.$store.state.me;
    window.addEventListener('resize', this.handleResize);
  },
  methods: {
    // 监听分辨率分栏
    handleResize () {
      this.winSize = document.documentElement.clientWidth;
      this.column = this.winSize > 1023 ? 3 : (this.winSize > 600 ? 2 : 1);
      this.cols = {};
      if (this.column === 1) {
        this.cols.col1 = this.collectionList;
      } else if (this.column === 2) {
        this.cols.col1 = this.collectionList.slice(0, this.collectionList.length / 2 + 1);
        this.cols.col2 = this.collectionList.slice(this.collectionList.length / 2 + 1);
      } else {
        this.cols.col1 = this.collectionList.slice(0, this.collectionList.length / 3 + 1);
        this.cols.col2 = this.collectionList.slice(this.cols.col1.length, this.collectionList.length / 3 * 2 + 1);
        this.cols.col3 = this.collectionList.slice(this.collectionList.length / 3 * 2 + 1);
      }
    },
    // 获取收藏集
    getCollections () {
      this.$http.get('collections').then(res => {
        this.collectionList = res.data.data;
        this.handleResize();
      });
    }
  }
};
</script>
<style lang="less">
</style>
