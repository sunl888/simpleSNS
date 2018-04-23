<template>
<div>
  <p>收藏集</p>
  <div ref="collection-list" class="collection-list">
    <!-- <div class="cover left_gradient"> -->
        <div class="btn_left" v-show="scrollLeftShow" :class="{'left_gradient':scrollLeftShow}">
          <mu-float-button @click.native="scrollLeft()" icon="keyboard_arrow_left" mini class="demo-float-button"/>
        </div>
        <div class="btn_right" v-show="scrollRightShow"  :class="{'right_gradient':scrollRightShow}">
          <mu-float-button @click="scrollRight()" icon="keyboard_arrow_right" mini class="demo-float-button"/>
        </div>
    <div ref="collection" class="collections clear_fixed">
      <collect-card v-for="(value, index) in collectionList"  :key="index" :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color" :value="value.id" :isSubscribe="value.is_author"></collect-card>
    </div>  </div>

  <mu-flexbox class="find_article" :gutter="40" align="stretch" justify="center">
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
      currentIndex: 0,
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
      scrollLeftShow: this.currentIndex > 0,
      scrollRightShow: true,
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
    scrollLeft () {
      this.currentIndex--;
      this.$refs.collection.style.marginLeft = -225 * this.currentIndex + 'px';
      this.scrollLeftShow = this.currentIndex > 0;
      this.scrollRightShow = this.currentIndex < this.collectionList.length - Math.round(this.$refs['collection-list'].offsetWidth / 225);
    },
    scrollRight () {
      this.currentIndex++;
      this.$refs.collection.style.marginLeft = -225 * this.currentIndex + 'px';
      this.scrollLeftShow = this.currentIndex > 0;
      this.scrollRightShow = this.currentIndex < this.collectionList.length - Math.round(this.$refs['collection-list'].offsetWidth / 225);
    },
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
        this.scrollRightShow = this.currentIndex < this.collectionList.length - Math.round(this.$refs['collection-list'].offsetWidth / 225);
      });
    }
  }
};
</script>
<style lang="less">
.left_gradient{
  background: linear-gradient(to right,#f1f1f1, rgba(255,255,255,0));
}
.right_gradient{
  background: linear-gradient(to left,#f1f1f1,rgba(255,255,255,0));
}
.collection-list{
  overflow: hidden;
  position: relative;
  .btn_left, .btn_right {
    top: 0;
    z-index: 10;
    position: absolute;
    height: 100%;
    width: 80px;
  }
  .demo-float-button{
    background: #fff;
    color: #444;
    position: absolute;
    top: 50%;
    margin: 0 20px;
    transform: translateY(-50%);
    box-shadow:0 6px 10px 0 rgba(0,0,0,0.14), 0 1px 18px 0 rgba(0,0,0,0.12), 0 3px 5px -1px rgba(0,0,0,0.2);
  }
  .btn_left{
    left: 0;
  }
  .btn_right{
    right: 0;
  }
  .collections {
    width: 10000px;
    .collect_card{
      margin: 0;
      width: 200px;
      margin-right: 25px;
      float: left;
    }
  }
}
  .find_article{
    margin-top: 30px;
  }
</style>
