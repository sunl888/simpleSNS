<template>
<div>
  <mu-flexbox wrap="wrap" class="collection">
    <mu-flexbox-item class="cover">
      <mu-icon-menu
        class="cover_menu"
        icon="more_vert"
        :anchorOrigin="leftTop"
        :targetOrigin="leftTop"
      >
        <mu-menu-item @click="isCreatePanel = true" title="修改收藏集" />
        <mu-menu-item title="删除收藏集" />
      </mu-icon-menu>
      <img src="../assets/images/bg.png" alt="">
      <div class="my_photo">
        <img src="../assets/images/temp.jpg" alt="">
      </div>
      <div class="cover_text">
        <span>aki 朱</span>
        <h1>山崎贤人</h1>
        <p>0评论0赞 - 私密收藏集</p>
      </div>
    </mu-flexbox-item>
    <mu-flexbox-item class="collects">
      <article-card class="card" v-for="x in 10" :key="x"></article-card>
    </mu-flexbox-item>
  </mu-flexbox>
  <mask-box :isMask = "isCreatePanel">
    <collect-made-panel type="edit" v-on:closeCMP = "isCreatePanel = false"></collect-made-panel>
  </mask-box>
</div>
</template>
<script>
import ArticleCard from '../components/ArticleCard/ArticleCard.vue';
import {CollectMadePanel} from '../components/CollectMade';

export default{
  data () {
    return {
      // 是否显示修改收藏集面板
      isCreatePanel: false,
      leftTop: {horizontal: 'left', vertical: 'top'}
    };
  },
  components: {
    ArticleCard,
    CollectMadePanel
  },
  methods: {
  }
};
</script>
<style lang="less">
.item_inner{
  position: relative;
}
.collection{
  width: 100%;
  height: 100%;
  position: absolute;
  left: 0;
  top: 0;
  .cover{
    width: 25%;
    min-width: 300px;
    flex: 0 auto!important;
    display: flex;
    background: orangered;
    flex-direction: column;
    height: 100%;
    position: relative;
    .cover_menu{
      position: absolute;
      color: #fff;
      right: 0;
    }
    &>img{
      width: 100%;
      height: 200px;
    }
    &>.my_photo{
      width: 80px;
      height: 80px;
      border-radius: 50%;
      overflow: hidden;
      position: relative;
      top: -40px;
      left: 20px;
      border: 2px solid #fff;
      img{
        width: 100%;
        height: 100%;
      }
    }
    .cover_text{
      color: #fff;
      padding: 0 30px;
      margin-top: -30px;
    }
  }
  .collects{
    height: 100%;
    overflow: auto;
    display: flex;
    flex-flow: row wrap;
    flex: 0 none!important;
    padding: 10px 10px 0 0;
    .card{
      margin: 0 10px 10px 0;
      width: 48%;
    }
  }
}
</style>

