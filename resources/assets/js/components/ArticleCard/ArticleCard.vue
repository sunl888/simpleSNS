<template>
<div v-if="me !== null" class="article_card">
  <slot></slot>
  <mu-icon-button v-if="closeable" @click="mask = false" icon="cancel"></mu-icon-button>
    <mu-card v-if="value !== null" @mouseover.native="cardMenu = true" :class="{'active_panel' : wasChoose === true}" @mouseout.native="cardMenu = false" @click.native="wasChoose = !wasChoose" class="clear_fixed">
      <mu-card-header class="clear_fixed" :title="value.user.nickname">
        <mu-avatar :src="value.user.avatar_hash.url" slot="avatar"/>
        <i class="material-icons">play_arrow</i>
        <router-link :to="{name: 'collection', params: {collection_id: value.collection.id}}" class="mu-card-sub-title"> {{value.collection.title}}</router-link>
        <div v-if="cardMenu" class="time">
        <mu-icon-button v-if="value.user.id !== me.id" icon="open_in_new"></mu-icon-button>
         <mu-icon-menu
            v-else
            @mouseout.native.stop
            icon="more_vert"
            :anchorOrigin="leftTop"
            :targetOrigin="leftTop"
          >
            <mu-menu-item title="修改" @click.native="$emit('openAEP', value)"/>
            <mu-menu-item title="删除" @click.native="deleteArticle"/>
            <mu-menu-item title="转发" @click.native="deleteArticle"/>
          </mu-icon-menu>
        </div>
        <span v-else class="time">2小时前</span>
      </mu-card-header>
      <mu-card-text>
        {{value.post_content.data.content}}
      </mu-card-text>
      <mu-card-media>
        <img :src="value.cover.url" />
      </mu-card-media>
      <div class="bottom">
        <div class="all_comments_box">
          <a>显示所有评论(共5条)</a>
          <div class="all_comments">
            <div class="my_photo">
              <span v-if="me.avatar_hash === null">{{me.nickname.substr(0, 1)}}</span>
              <img v-else :src="me.avatar_hash.url" alt="">  
            </div>
            <strong>{{me.nickname}}</strong>
            <p>nice!</p>
          </div>
        </div>
        <div class="comment_area">
          <div class="my_photo">
            <span v-if="me.avatar === null">{{me.nickname.substr(0, 1)}}</span>
            <img v-else :src="me.avatar_hash.url" alt="">  
          </div>
          <textarea v-model="comment" placeholder="发表评论" cols="30" rows="1"></textarea>
          <div class="share_bar" @click.stop>
            <mu-card-actions v-if="!wasChoose" class="operation_btn">
              <mu-flat-button :class="{'up_thumb' : upStyle === true}" @click.native="thumbUP" icon="thumb_up" :label="String(upCount)"/>
              <mu-flat-button :class="{'down_thumb' : downStyle === true}" @click.native="thumbDown" icon="thumb_down" :label="String(downCount)"/>
            </mu-card-actions>
            <mu-card-actions v-else class="operation_btn">
              <mu-flat-button @click.native="submitComment" label="发布"/>
            </mu-card-actions>
          </div>
        </div>
      </div>
    </mu-card>
</div>
</template>
<script>
export default{
  data () {
    return {
      leftTop: {horizontal: 'left', vertical: 'top'},
      upCount: 0,
      downCount: 0,
      upStyle: false,
      downStyle: false,
      wasChoose: false,
      cardMenu: false,
      comment: null
    };
  },
  props: {
    mask: false,
    closeable: false,
    value: {
      type: Object,
      default: null
    }
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? null : this.$store.state.me;
    }
  },
  mounted () {
    this.getComment();
    this.getThumb();
  },
  methods: {
    // 删除文章
    async deleteArticle () {
      await this.$http.delete('posts/' + this.value.id).then(res => {
        this.$alert('已经删除啦', 'primary');
      });
      this.$emit('updatePost');
    },
    // 点赞/取消点赞
    thumbUP () {
      if (this.upStyle === false) {
        this.$http.patch('post/' + this.value.id + '/up_vote').then(res => {
          this.upCount = res.data.up_votes_count;
          this.upStyle = true;
          this.downStyle = false;
        });
      } else {
        this.$http.patch('post/' + this.value.id + '/' + 'cancel_vote').then(res => {
          this.upCount = res.data.up_votes_count;
          this.getThumb();
          this.upStyle = false;
        });
      }
      // this.downStyle = !this.upStyle;
    },
    // 点踩/取消点踩
    thumbDown () {
      if (this.downStyle === false) {
        this.$http.patch('post/' + this.value.id + '/down_vote').then(res => {
          this.downCount = res.data.up_votes_count;
          this.downStyle = true;
          this.upStyle = false;
        });
      } else {
        this.$http.patch('post/' + this.value.id + '/' + 'cancel_vote').then(res => {
          this.downCount = res.data.up_votes_count;
          this.downStyle = false;
        });
      }
    },
    // 是否已经点赞/点踩
    getThumb () {
      if (this.value !== null) {
        for (let i in this.value.up_voters) {
          this.upStyle = this.value.up_voters[i].id === this.me.id;
        }
        for (let i in this.value.down_voters) {
          this.downStyle = this.value.down_voters[i].id === this.me.id;
        }
        this.upCount = this.value.up_voters_count;
        this.downCount = this.value.down_voters_count;
      }
    },
    // 获取评论
    getComment () {
      this.$http.get('posts/' + this.value.id + '/comments').then(res => {
        console.log(res);
      });
    },
    // 提交评论
    submitComment () {
      this.$http.post('posts/' + this.value.id + '/comment', {
        content: this.comment
      }).then(res => {
        console.log(res);
      });
    }
  }
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
    padding: 16px 16px 0 16px;
    .mu-avatar, .mu-card-header-title, .mu-card-title, &>i{
        display: block;
        line-height: 48px;
        float: left;
      }
      &>i{
        font-size: 14px;
        margin: 0 5px;
      }
      .mu-card-sub-title{
        color: #20a0ff;
        max-width: 40%;
        float: left;
        display: block;
        line-height: 48px;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
      }
    .mu-card-header-title{
      padding-right: 0;
    }
  }
  .mu-card-text{
    word-wrap:break-word;
    padding: 10px 16px 5px;
  }
  span{
    color: #888;
    padding: 14px 0;
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
      .mu-icon{
        // font-size: 20px;
        text-align: center;
        // line-height: 5px;
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
.up_thumb{
  color: #f44336;
}
.down_thumb{
  color: #1b5e20;
}
</style>
