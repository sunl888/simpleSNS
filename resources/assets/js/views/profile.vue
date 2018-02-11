<template>
<div class="profile clear_fixed">
  <mu-flexbox class="profile" orient="vertical">
    <mu-flexbox-item>
      <mu-paper class="profile_top">
        <img :src="me.avatar_hash.cover_url">
        <!-- <img src="../assets/images/bg.png"> -->
        <div class="modify_box clear_fixed">
          <img :src="me.avatar_hash.url">
          <strong>{{me.nickname}}</strong>
          <mu-raised-button @click="isEditMe = true">{{me.tel_num === null ? '完善资料' : '修改资料'}}</mu-raised-button>
          <div class="more">
            <p>
              <strong>真实姓名 {{me.name}}</strong>
              <strong>手机号码 {{me.tel_num}}</strong>
              <strong>邮箱 {{me.email}}</strong> 
            </p>
            <p>
              <strong>城市 {{me.city}}</strong>
              <strong>详细地址 {{me.location}}</strong>
              <strong>所属公司 {{me.company}}</strong>
            </p>
            <p>
              <strong>个性签名 {{me.introduction}}</strong>
            </p>
          </div>
        </div>
      </mu-paper>
    </mu-flexbox-item>
  </mu-flexbox>
  <p>我的收藏集<router-link :to="{name: 'all_collections'}">更多</router-link></p>
  <mu-flexbox justify="space-between" class="collect">
    <mu-flexbox-item>
      <collect-create v-on:openCMP = "isCreatePanel = true"></collect-create>
    </mu-flexbox-item>
    <mu-flexbox-item v-for="(value, index) in (me.collections.data.slice(0, this.column) || myCollection)" :key="index">
      <collect-card :value="value.id" :cover="value.cover.url" :avator="value.user.avatar_hash.url" :title="value.title" :color="value.color"></collect-card>
    </mu-flexbox-item>
  </mu-flexbox>
  <p>动态</p>
  <mu-flexbox>
    <mu-flexbox-item>
      <article-card class="profile_article"></article-card>
    </mu-flexbox-item>
  </mu-flexbox>
  <mask-box :isMask = "isCreatePanel">
    <collect-made-panel v-on:closeCMP = "isCreatePanel = false" type="create"></collect-made-panel>
  </mask-box>
  <mask-box :isMask = "isEditMe">
    <edit-me @closeEM="isEditMe = false"></edit-me>
  </mask-box>
</div>
</template>
<script>
import {CollectCard, CollectCreate} from '../components/CollectCard';
import {CollectMadePanel} from '../components/CollectMade';
import EditMe from '../components/EditMe/EditMe.vue';
import ArticleCard from '../components/ArticleCard/ArticleCard.vue';
export default{
  components: {
    CollectCard,
    CollectCreate,
    CollectMadePanel,
    ArticleCard,
    EditMe
  },
  data () {
    return {
      // 当前窗口宽度
      winSize: document.documentElement.clientWidth,
      column: this.winSize > 1400 ? 5 : (this.winSize > 1023 ? 3 : (this.winSize > 600 ? 2 : 1)),
      // 是否显示创建收藏集面板
      isCreatePanel: false,
      // 我的收藏集
      myCollection: [],
      // 是否显示修改资料面板
      isEditMe: false
    };
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? null : this.$store.state.me;
    }
  },
  mounted () {
    this.handleResize();
    window.addEventListener('resize', this.handleResize);
  },
  methods: {
    // 监听分辨率分栏
    handleResize () {
      if (this.me !== null) {
        this.winSize = document.documentElement.clientWidth;
        this.column = this.winSize > 1400 ? 5 : (this.winSize > 1023 ? 3 : 1);
        this.myCollection = this.me.collections.data.slice(0, this.column);
      } else {
        this.myCollection = null;
      }
    },
  }
};
</script>
<style lang="less">
.profile{
  &>p{
    width: 100%;
    padding: 30px 0 20px;
    font-size: 18px;
    color: #666;
    float: left;
    a{
      float: right;
      color: #20a0ff;
    }
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
  padding: 80px 20px;
  flex-direction: row;
  position: absolute;
  bottom: 0;
  // position: relative;
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
  .more{
    position: absolute;
    bottom: 0;
  }
}
.profile_article{
  max-width: 50%;
}
.a{
  height: 1000px;
}
.collect{
  overflow: auto;
}
@media (max-width: 900) {
.collect{
  flex-direction: column!important;
}
}
</style>
