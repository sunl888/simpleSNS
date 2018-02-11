<template>
<div class="article_card">
  <slot></slot>
  <mu-icon-button v-if="closeable" @click="closeArticleCard" icon="cancel"></mu-icon-button>
  <div @mouseenter="cardMenu = true" @click="chhoseThePanel()" :class="{'active_panel' : wasChoose === true}"  @mouseleave="cardMenu = false">
    <mu-card class="clear_fixed">
      <mu-card-header class="clear_fixed" :title="nickname">
        <mu-avatar :src="avatar" slot="avatar"/>
        <i class="material-icons">play_arrow</i>
        <router-link :to="{name: 'collection', params: {collection_id: collection.id}}" class="mu-card-sub-title"> {{collection.title}}</router-link>
        <div v-if="cardMenu" class="time">
          <mu-icon-button icon="open_in_new"></mu-icon-button>
          <mu-icon-menu
            slot="right"
            icon="more_vert"
            :anchorOrigin="leftTop"
            :targetOrigin="leftTop"
          >
            <mu-menu-item title="关注收藏集"/>
            <mu-menu-item title="不再显示此收藏集"/>
          </mu-icon-menu>
        </div>
        <span v-else class="time">2小时前</span>
      </mu-card-header>
      <mu-card-text>
        {{content}}
      </mu-card-text>
      <mu-card-media>
        <img :src="cover" />
      </mu-card-media>
      <div class="all_comments_box">
        <a>显示所有评论(共5条)</a>
        <div class="all_comments">
          <div class="my_photo">
            <span v-if="me.avatar === null">{{me.nickname.substr(0, 1)}}</span>
            <!-- <img v-else :src="me.avatar.data.url" alt="">   -->
          </div>
          <strong>{{me.nickname}}</strong>
          <p>nice!</p>
        </div>
      </div>
      <div class="comment_area">
        <div class="my_photo">
          <span v-if="me.avatar === null">{{me.nickname.substr(0, 1)}}</span>
          <!-- <img v-else :src="me.avatar.data.url" alt="">   -->
        </div>
        <textarea placeholder="发表评论" cols="30" rows="1"></textarea>
        <div v-if="!wasChoose" class="share_bar">
          <mu-icon-button icon="exposure_plus_1"/>
          <mu-icon-button icon="share"/>
        </div>
      </div>
      <div v-if="wasChoose" class="text_bar">
        <mu-icon-button icon="photo_camera"/>
        <mu-icon-button icon="link"/>
        <mu-card-actions class="operation_btn">
          <mu-flat-button label="取消"/>
          <mu-flat-button label="发布"/>
        </mu-card-actions>
      </div>
    </mu-card>
  </div>
</div>
</template>
<script>
export default{
  data () {
    return {
      leftTop: {horizontal: 'left', vertical: 'top'},
      wasChoose: false,
      cardMenu: false
    };
  },
  props: {
    mask: false,
    closeable: false,
    // 昵称
    nickname: '',
    // 头像
    avatar: '',
    // 所属收藏集
    collection: '',
    // 内容
    content: '',
    // 文章插图
    cover: ''
  },
  methods: {
    chhoseThePanel () {
      this.wasChoose = !this.wasChoose;
    },
    closeArticleCard () {
      this.mask = false;
    }
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
};
</script>
<style lang="less">
.mask{
  &>.mu-icon-button{
    // float: right;
    color: #fff;
    position: absolute;
    right: 20px;
    top: 20px;
  }
}
.article_card{
  // float: right;
  // min-width: 420px;
  // margin-right: 15px;
  .mu-card-header{
    .mu-avatar, .mu-card-header-title, .mu-card-title, .mu-card-sub-title, &>i{
        display: block;
        line-height: 40px;
        float: left;
      }
      .mu-card-sub-title{
        color: #20a0ff;
      }
    .mu-card-header-title{
      padding-right: 10px;
    }
  }
  .mu-card-text{
    word-wrap:break-word;
  }
  span{
    color: #888;
    padding: 5px;
    display: inline-block;
  }
  &>div{
    transition: box-shadow 0.3s;
  }
  .text_bar{
    float: left;
    width: 100%;
    color: #777;
  }
  .time{
    float: right;
    .mu-icon-button{}
  }
  .operation_btn{
    float: right;
  }
  .comment_area, .all_comments{
    width: 100%;
    display: flex;
    padding: 0 0 15px 0;
    .my_photo{
      padding: 0 10px;
      span,strong{
        float: left;
      }
      &>span, &>img{
        display: block;
        width: 30px;
        font-size: 25px;
        line-height: 15px;
        text-align: center;
        height: 30px;
        margin: 17px 15px 0 0px;
        color: #fff;
        border-radius: 50%;
        background: #A0C3FF;
      }
      &>strong{
        font-size: 15px;
      }
    }
    textarea{
      // width: calc(~"100% - 85px");
      resize: none;
      outline: none;
      border: none;
      min-height: 16px;
      flex: 5 1 auto;
      font-size: 16px;
      margin-top: 20px;
    }
    .share_bar{
      // float: right;
      flex:  1 1 auto;
      margin-top: 10px;
      .mu-icon-button{
        background: #eee;
        margin-left: 10px;
      }
    }
  }
  .all_comments_box, .all_comments{
    padding: 10px 10px;
  }
}
.active_panel{
  box-shadow: 0 0 20px rgba(0,0,0,0.3);
}
</style>
