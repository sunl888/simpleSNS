<template>
<div class="find_tiny_card">
  <mu-card @click.native="openArticleCard" class="clear_fixed">
    <mu-card-media>
      <img src="../../assets/images/temp.jpg" />
    </mu-card-media>
    <mu-card-text>
      test text test text test text test text test text test text test texttest texttest text
    </mu-card-text>
    <mu-card-header title="Myron Avatar" subTitle="sub title">
      <mu-avatar src="../../assets/images/temp.jpg" slot="avatar"/>
    </mu-card-header>
  </mu-card>
</div>
</template>
<script>
export default{
  data () {
    return {
      wasChoose: false,
      cardMenu: false
    };
  },
  methods: {
    chhoseThePanel () {
      this.wasChoose = !this.wasChoose;
    },
    openArticleCard () {
      this.$root.$children[0].$children[0].$children[3].mask = true;
    }
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  }
};
</script>
<style lang="less">
.find_tiny_card{
  width: 100%;
  .mu-card{
    margin: 10px 0;
    span{
      color: #888;
      padding: 5px;
      display: inline-block;
    }
  }
  .article_card{
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.5);
    position: absolute;
    top: 0;
  }
}
</style>
