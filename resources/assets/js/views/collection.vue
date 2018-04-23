<template>
<div>
  <mu-flexbox ref="view" wrap="wrap" class="collection">
    <mu-flexbox-item class="cover" :style="{background : item.color}">
      <mu-icon-menu
        class="cover_menu"
        icon="more_vert"
        :anchorOrigin="leftTop"
        :targetOrigin="leftTop"
      >
        <mu-menu-item @click="isCreatePanel = true" title="修改收藏集" />
        <mu-menu-item @click="deleteCollection" title="删除收藏集" />
      </mu-icon-menu>
      <img :src="item.cover.url" alt="">
      <div class="my_photo">
        <img :src="item.user.avatar_hash.url" alt="">
      </div>
      <div class="cover_text">
        <span @click="goProfile">{{item.user.name}}</span>
        <h2>{{item.title}}</h2>
        <p>{{item.introduction}}</p>
        <mu-raised-button @click.native="orderCollection" class="order_collection">{{isSubscribe === true ? '取消订阅' : '订阅'}}</mu-raised-button>
      </div>
    </mu-flexbox-item>
    <mu-flexbox-item class="collects">
      <article-card v-if="posts.length>0" class="card" v-for="(post, index) in posts" :key="index" :value="post"></article-card>
      <h3 class="collection_tips" v-if="posts.length === 0">这个收藏集是空的哦</h3>
    </mu-flexbox-item>
  </mu-flexbox>
  <mask-box :isMask = "isCreatePanel">
    <collect-made-panel v-on:updateCCI = "getItem" type="edit" v-on:closeCMP = "isCreatePanel = false"></collect-made-panel>
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
      leftTop: {horizontal: 'left', vertical: 'top'},
      // 收藏集详情
      item: [],
      posts: [],
      // 是否被订阅
      isSubscribe: false
    };
  },
  components: {
    ArticleCard,
    CollectMadePanel
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? null : this.$store.state.me;
    }
  },
  mounted () {
    this.getItem();
    this.getPosts();
  },
  methods: {
    // 获取收藏集详情
    getItem () {
      this.$http.get('collections/' + this.$route.params.collection_id).then(res => {
        this.item = res.data.data;
        this.formData = {
          title: res.data.data.title,
          introduction: res.data.data.introduction,
          color: res.data.data.color,
          cover_url: res.data.data.cover.url
        };
      });
    },
    // 订阅收藏集
    orderCollection () {
      this.isSubscribe = !this.isSubscribe;
      this.$http.post('collections/' + this.$route.params.collection_id + '/subscribe').then(res => {
        if (this.isSubscribe) {
          this.$alert('已经成功订阅收藏集《' + this.formData.title + '》', 'primary');
        } else {
          this.$alert('已经取消订阅收藏集《' + this.formData.title + '》', 'primary');
        }
      });
    },
    // 删除收藏集
    deleteCollection () {
      this.$http.delete('collections/' + this.$route.params.collection_id).then(res => {
        this.$alert('你已经成功删除此收藏集', 'primary');
        this.$store.dispatch('updateMe');
        this.$router.back();
      });
    },
    goProfile () {
      if (this.item.user !== null) {
        if (this.me.id === this.item.user.id) {
          this.$router.push({name: 'me'});
        } else {
          this.$router.push({
            name: 'profile',
            params: {userId: this.item.user.id}
          });
        }
      }
    },
    getPosts () {
      this.$http.get('posts?include=post_content&collection_id=' + this.$route.params.collection_id).then(res => {
        this.posts = res.data.data;
      });
    }
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
    flex-direction: column;
    height: 100%;
    position: relative;
    .cover_menu{
      position: absolute;
      color: #fff;
      right: 0;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 50%;
      margin: 10px;
    }
    &>img{
      width: 100%;
      height: 40%;
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
      word-wrap:break-word;
      span, h2, p{
        margin-top: 5px;
      }
    }
  }
  .collects{
    height: 100%;
    overflow: auto;
    display: flex;
    flex-flow: row wrap;
    flex: 0 none!important;
    padding: 10px 10px 0 0;
    .collection_tips{
      text-align: center;
      color: #999;
      margin: 200px auto;
    }
    .card{
      margin: 0 10px 10px 0;
      width: 48%;
    }
  }
  .order_collection{
    padding: 5px 8px;
    margin-top: 20px;
  }
}
</style>

