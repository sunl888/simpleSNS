<template>
<div>
  <div class="collections">
    <collect-card v-for="(value, index) in collectionList" :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.collection.title" :color="value.collection.color" :value="value.id" :isSubscribe="value.is_author" :key="index"></collect-card>
  </div>
  <mu-flexbox v-if="isFind === true" class="find" :gutter="40" align="stretch" justify="center">
    <mu-flexbox-item style="width: 100%">
      <find-tiny-card v-for="(value, index) in cols.col1" :value="value" :key="index"></find-tiny-card>
    </mu-flexbox-item>
    <mu-flexbox-item style="width: 100%" v-if="this.column > 1" >
      <find-tiny-card v-for="(value, index) in cols.col2" :value="value" :key="index"></find-tiny-card>
    </mu-flexbox-item>
    <mu-flexbox-item style="width: 100%" v-if="this.column > 2" >
      <find-tiny-card v-for="(value, index) in cols.col3" :value="value" :key="index"></find-tiny-card>
    </mu-flexbox-item>
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
    this.getItem();
    await this.getCollections();
    this.me = this.$store.state.me === null ? null : this.$store.state.me;
    this.isFind = this.$route.name === 'find';
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
    async getItem () {
      await this.$http.get('posts?include=post_content').then(res => {
        this.item = res.data.data;
      });
      this.handleResize();
    },
    // 获取收藏集
    getCollections () {
      this.$http.get('collections').then(res => {
        this.collectionList = res.data.data;
      });
    }
  }
};
</script>
<style lang="less">
</style>
