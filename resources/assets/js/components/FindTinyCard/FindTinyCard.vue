<template>
<div class="find_tiny_card">
  <mu-card @click.native="openArticleCard" class="clear_fixed">
    <mu-card-media>
      <img :src="value.cover.cover_url" />
    </mu-card-media>
    <mu-card-text>
      {{value.post_content.data.content}}
    </mu-card-text>
    <mu-card-header :title="value.user.name" :subTitle="value.collection.title">
      <mu-avatar :src="value.user.avatar_hash.cover_url" slot="avatar"/>
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
  props: {
    value: Object
  },
  mounted () {
    console.log(this.value);
  },
  methods: {
    choseThePanel () {
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
