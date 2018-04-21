<template>
  <mu-paper position="bottom" overlay class="demo-popup-bottom clear_fixed">
    <mu-appbar>
     <div class="my_photo clear_fixed">
        <span v-if="me.avatar_hash === null">{{me.nickname.substr(0, 1)}}</span>
        <img v-else :src="me.avatar_hash.url"> 
        <strong>{{me.nickname}}</strong>
        <i class="material-icons">play_arrow</i>
        <p @click="isCS = true">{{ collection === null || collection.title === null ? '选择收藏集' : collection.title}}</p>
      </div>
      <mu-icon-menu
        slot="right"
        icon="more_vert"
        :anchorOrigin="leftTop"
        :targetOrigin="leftTop"
      >
        <mu-menu-item title="禁止评论"/>
        <mu-menu-item title="禁止转发"/>
      </mu-icon-menu>
    </mu-appbar>
    <textarea v-model="formData.content" placeholder="有什么新鲜事要分享吗" class="type_words"></textarea>
    <img class="article_img_cover" v-if="formData.cover_url !== null" :src="cover_url" alt="">
    <div class="text_bar clear_fixed">
      <mu-flat-button icon="photo_camera" class="demo-flat-button">
        <input ref="uploadEle" @change="uploadImg" type="file" class="file-button">
      </mu-flat-button>
      <mu-dropDown-menu :value="formData.status" @change="handleChange">
        <mu-menu-item value="publish" title="公开"/>
        <mu-menu-item value="draft" title="仅自己"/>
      </mu-dropDown-menu>
      <!-- <mu-icon-button icon="link"/> -->
    </div>
    <!-- <div class="article_img_cover">
      <img v-if="formData.cover_url === null" src="../../assets/images/bg.png" alt="">
      <img v-else :src="formData.cover_url" alt="">
    </div> -->
    <div class="operation_btn">
      <mu-flat-button @click="$emit('closeACP')" label="取消" class="demo-flat-button"/>
      <mu-raised-button @click="createArticle" label="发布" class="demo-raised-button"/>
    </div>
    <mask-box :isMask="isCS">
      <collection-select @closeCS="setCollection" v-on:openCMP="isCreatePanel = true" v-on:closeCS = "isCS = false"></collection-select>
    </mask-box>
    <mask-box :isMask = "isCreatePanel">
      <collect-made-panel v-on:closeCMP = "isCreatePanel = false" type="create"></collect-made-panel>
    </mask-box>
  </mu-paper>
</template>
<script>
import {CollectMadePanel} from '../CollectMade';
import CollectionSelect from '../CollectionSelect/CollectionSelect.vue';
export default{
  components: {
    CollectionSelect,
    CollectMadePanel
  },
  props: {
    editID: Number
  },
  data () {
    return {
      // 菜单弹出位置
      leftTop: {horizontal: 'left', vertical: 'top'},
      // 是否显示选择收藏集
      isCS: false,
      // 是否显示创建收藏集
      isCreatePanel: false,
      collection: null,
      cover_url: null,
      formData: {
        collection_id: null,
        content: null,
        cover: null,
        status: 'publish',
        published_at: null
      }
    };
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
  mounted () {
    if (this.editID !== undefined) {
      this.getItem();
    }
  },
  methods: {
    handleChange (val) {
      this.formData.status = val;
    },
    setCollection (collection) {
      this.collection = collection;
      this.formData.collection_id = collection.id;
    },
    // 发布文章 || 修改文章
    async createArticle () {
      if (this.editID === undefined) {
        await this.$http.post('posts', this.formData);
        setTimeout(function () {
          this.$emit('updatePost');
        }.bind(this), 500);
      } else {
        await this.$http.put('posts/' + this.editID, this.formData);
        this.$emit('updatePost');
        this.$alert('已经成功修改啦', 'primary');
      }
    },
    // 上传图片
    uploadImg () {
      let file = this.$refs['uploadEle'].files[0];
      let formData = new FormData();
      formData.append('image', file, file.name);
      this.$http.post('ajax_upload_image', formData, {
        headers: {'Content-Type': 'multipart/form-data'}
      }).then(res => {
        this.formData.cover = res.data.image_hash;
        this.cover_url = res.data.image_url;
      });
    },
    // 获取文章详情
    getItem () {
      this.$http.get('posts/' + this.editID + '?include=post_content').then(res => {
        this.formData = {
          collection_id: res.data.data.collection.id,
          content: res.data.data.post_content.data.content,
          cover: res.data.data.cover.hash,
          status: res.data.data.status,
          published_at: res.data.data.published_at
        };
        this.collection = res.data.data.collection;
        this.cover_url = res.data.data.cover.url;
      });
    }
  }
};
</script>
<style lang="less">
.demo-popup-bottom{
  width: 100%;
  min-width: 350px;
  padding-bottom: 10px;
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 12;
  transform: translate(-50%, -50%);
  .my_photo{
    &>span, &>img{
      display: block;
      width: 30px;
      line-height: 25px;
      text-align: center;
      height: 30px;
      margin: 17px 15px 0 0px;
      color: #fff;
      border-radius: 50%;
      background: #A0C3FF;
    }
    &>span, &>img, &>strong, &>i{
      float: left;
      line-height: 64px;
    }
    &>strong{
      font-size: 15px;
    }
    &>i{
      font-size: 14px;
      margin: 0 5px;
    }
    &>p{
      font-size: 15px;
      color: #20a0ff;
      line-height: 64px;
      overflow: hidden;
      text-overflow:ellipsis;
      white-space: nowrap;
    }
  }
  .mu-appbar{
    background: #fff;
    color: #444;
  }
  .mu-paper-1{
    box-shadow: 0 0px 0px rgb(255,255,255), 0 0px 0px rgb(255,255,255);
  }
  .type_words{
    background: transparent;
    border: 0;
    font-size: 15px;
    // height: 100%;
    line-height: 18px;
    margin: 0;
    min-height: 120px;
    outline: none;
    padding: 0 20px 20px;
    resize: none;
    width: 100%;
  }
  .text_bar{
    border-bottom: 1px solid #eee;
    padding: 0 5px;
    .mu-flat-button{
      border-radius: 50%;
      width: 50px;
      min-width: 50px;
      height: 50px;
      color: #444;
      float: left;
    }
    .mu-dropDown-menu{
      float: right;
      margin-top: -5px;
    }
  }
  .article_img_cover{
    // width: 100%;
    max-width: 80%;
    max-height: 300px;
    margin: 10px auto;
    display: block;
  }
  .operation_btn{
    margin-top: 10px;
    float: right;
    margin-right: 20px;
    .mu-flat-button{
      margin-right: 20px;
    }
  }
}
</style>
