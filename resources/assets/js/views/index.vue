<template>
  <div class="index clear_fixed">
    <mu-flexbox :gutter="40" align="flex-start" justify="center">
      <mu-flexbox-item class="flex-demo">
        <article-create></article-create>
        <article-card v-for="x in 10" :key="x"></article-card>
      </mu-flexbox-item>
      <mu-flexbox-item v-if="this.column > 1" class="flex-demo">
        <article-card v-for="x in 10" :key="x"></article-card>
      </mu-flexbox-item>
      <mu-flexbox-item v-if="this.column > 2" class="flex-demo">
        <article-card v-for="x in 10" :key="x"></article-card>
      </mu-flexbox-item>
    </mu-flexbox>
  </div>
</template>
<script>
import {ArticleCreate} from '../components/ArticleCreate';
import ArticleCard from '../components/ArticleCard/ArticleCard.vue';
export default{
  components: {
    ArticleCreate,
    ArticleCard
  },
  data () {
    return {
      winSize: window.screen.width,
      column: this.winSize > 1400 ? 3 : (this.winSize > 1023 ? 2 : 1)
    };
  },
  watch: {
    // 'winSize' () {
    //   console.log(this.winSize);
    // }
  },
  mounted () {
    this.handleResize();
    window.addEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize () {
      this.winSize = document.documentElement.clientWidth;
      this.column = this.winSize > 1400 ? 3 : (this.winSize > 1023 ? 2 : 1);
    }
  }
};
</script>
<style lang="less" scoped>
.index{
  width: 100%;
  display: flex;
  flex-flow: row wrap;
  align-content: center;
  flex: 0 0 auto;
  justify-content: center;
  margin: 0 auto;
}
</style>
