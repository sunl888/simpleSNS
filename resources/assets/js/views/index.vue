<template>
  <div class="index clear_fixed">
    <mu-flexbox :gutter="40" align="flex-start" justify="center">
      <mu-flexbox-item class="flex-demo">
        <article-create v-on:openACP = "isCreatePanel = true"></article-create>
        <article-card v-for="(x, index) in cols.col1" :key="index" :content="x.title" :nickname="x.user.nickname" :collection="x.collection.title">
          <span>热点信息</span>
        </article-card>
      </mu-flexbox-item>
      <mu-flexbox-item v-if="this.column > 1" class="flex-demo">
        <article-card v-for="(x, index) in cols.col2" :key="index" :content="x.title" :nickname="x.user.nickname" :collection="x.collection.title">
          <span>热点信息</span>
        </article-card>     
      </mu-flexbox-item>
      <mu-flexbox-item v-if="this.column > 2" class="flex-demo">
        <article-card v-for="(x, index) in cols.col3" :key="index" :content="x.title" :nickname="x.user.nickname" :collection="x.collection.title">
          <span>热点信息</span>
        </article-card> 
      </mu-flexbox-item>
    </mu-flexbox>
    <mask-box :isMask = "isCreatePanel">
      <article-create-panel v-on:closeACP = "isCreatePanel = false"></article-create-panel>
    </mask-box>
  </div>
</template>
<script>
import {ArticleCreate, ArticleCreatePanel} from '../components/ArticleCreate';
import ArticleCard from '../components/ArticleCard/ArticleCard.vue';
export default{
  components: {
    ArticleCreatePanel,
    ArticleCreate,
    ArticleCard
  },
  data () {
    return {
      // 当前窗口宽度
      winSize: window.screen.width,
      // 根据当前分辨率判断显示几列内容
      column: this.winSize > 1400 ? 3 : (this.winSize > 1023 ? 2 : 1),
      // 文章列表
      item: [],
      // 是否显示写文章
      isCreatePanel: false,
      // 文章分栏
      cols: {}
    };
  },
  mounted () {
    this.getItem();
    window.addEventListener('resize', this.handleResize);
  },
  methods: {
    // 监听分辨率分栏
    handleResize () {
      this.winSize = document.documentElement.clientWidth;
      this.column = this.winSize > 1400 ? 3 : (this.winSize > 1023 ? 2 : 1);
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
      await this.$http.get('posts').then(res => {
        this.item = res.data.data;
      });
      this.handleResize();
    }
  }
};
</script>
<style lang="less">
.index{
  // width: 100%;
  // height: 100px;
  // display: flex;
  // flex-flow: row wrap;
  // align-content: center;
  // flex: 0 0 auto;
  // justify-content: center;
  // margin: 0 auto;
}
</style>
