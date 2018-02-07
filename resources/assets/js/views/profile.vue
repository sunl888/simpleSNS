<template>
<div class="profile">
  <mu-flexbox class="profile" orient="vertical">
    <mu-flexbox-item>
      <mu-paper class="profile_top">
        <img :src="me.avatar_hash.cover_url">
        <!-- <img src="../assets/images/bg.png"> -->
        <div class="modify_box">
          <img :src="me.avatar_hash.url">
          <strong>{{me.nickname}}</strong>
          <mu-raised-button>修改资料</mu-raised-button>
        </div>
      </mu-paper>
    </mu-flexbox-item>
  </mu-flexbox>
  <p>收藏集</p>
  <mu-flexbox :gutter="50" wrap="wrap" class="collect">
    <mu-flexbox-item>
      <collect-create v-on:openCCP = "openCCP"></collect-create>
    </mu-flexbox-item>
    <mu-flexbox-item>
      <collect-card></collect-card>
    </mu-flexbox-item>
    <mu-flexbox-item>
      <collect-card></collect-card>
    </mu-flexbox-item>
    <mu-flexbox-item>
      <collect-card></collect-card>
    </mu-flexbox-item>
  </mu-flexbox>
  <p>动态</p>
  <mu-flexbox>
    <mu-flexbox-item>
      <article-card class="profile_article"></article-card>
    </mu-flexbox-item>
  </mu-flexbox>
  <mask-box :isMask = "isCreatePanel">
    <collect-made-panel v-on:closeCMP = "isCreatePanel = false" type="create" v-on:closeCCP = "closeCCP"></collect-made-panel>
  </mask-box>
</div>
</template>
<script>
import {CollectCard, CollectCreate} from '../components/CollectCard';
import {CollectMadePanel} from '../components/CollectMade';
import ArticleCard from '../components/ArticleCard/ArticleCard.vue';
export default{
  components: {
    CollectCard,
    CollectCreate,
    CollectMadePanel,
    ArticleCard
  },
  data () {
    return {
      // 是否显示创建收藏集面板
      isCreatePanel: false
    };
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
  methods: {
    // 打开创建收藏集面板
    openCCP () {
      this.isCreatePanel = true;
    },
    // 关闭创建收藏集面板
    closeCCP () {
      this.isCreatePanel = false;
    }
  }
};
</script>
<style lang="less">
.profile{
  &>p{
    padding: 30px 0 20px;
    font-size: 18px;
    color: #666;
  }
}
.profile_top{
  flex: 1 1 auto;
  height: 500px;
  position: relative;
  &>img{
    width: 100%;
    top: 0;
    max-height: 500px;
    position: absolute;
    height: auto;
  }
}
.modify_box{
  width: 100%;
  padding: 20px 20px;
  flex-direction: row;
  position: absolute;
  bottom: 0;
  background-image: -webkit-linear-gradient(rgba(0,0,0,0),rgba(0,0,0,.46));
  background-image: linear-gradient(rgba(0,0,0,0),rgba(0,0,0,.46)); 
  &>img, &>strong{
    float: left;
  }
  &>img{
    width: 60px;
    height: 60px;
    padding: 2px;
    background: #fff;
    border-radius: 50%;
  }
  &>strong{
    line-height: 60px;
    color: #fff;
    margin-left: 20px;
    font-size: 22px;
  }
  &>.mu-raised-button{
    float: right;
    margin-top: 15px;
  }
}
.profile_article{
  max-width: 50%;
}
.a{
  height: 1000px;
}
@media (max-width: 900) {
.collect{
  flex-direction: column!important;
}
}
</style>
