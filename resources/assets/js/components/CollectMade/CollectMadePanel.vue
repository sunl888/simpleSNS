<template>
  <mu-paper class="collect_edit_panel">
    <mu-appbar :title="collect_edit_title">
      <mu-icon-button @click="$emit('closeCMP')" icon="close" slot="left"/>
      <mu-flat-button @click="createCollection" slot="right">确定</mu-flat-button>
    </mu-appbar>
    <div class="edit_box">
      <div class="cover">
        <img v-if="formData.cover_url === null" src="../../assets/images/bg.png" alt="">
        <img v-else :src="formData.cover_url" alt="">
        <mu-flat-button icon="photo_camera" class="demo-flat-button uploadEle">
          <input ref="uploadEle" @change="uploadImg" type="file" class="file-button">
        </mu-flat-button>
      </div>
      <div :style="{background : formData.color}" class="content">
        <mu-text-field v-model="formData.title" :underlineShow="false" hintText="名称" fullWidth></mu-text-field>
        <mu-text-field v-model="formData.introduction" :underlineShow="false" hintText="简介" fullWidth multiLine :rows="1" :maxLength="100"/>
      </div>
      <div class="color_select">
        <color-choose :class="{'active_color' : formData.color === value.color}" @click.native="formData.color = value.color" v-for="(value, index) in colors" :key="index" :themeColor="value.color">
        </color-choose>
      </div>
    </div>
  </mu-paper>
</template>
<script>
import ColorChoose from '../ColorChoose/ColorChoose.vue';
export default{
  components: {
    ColorChoose
  },
  props: {
    type: String
  },
  watch: {
  },
  data () {
    return {
      // 面板标题
      collect_edit_title: this.type === 'create' ? '创建收藏集' : '修改收藏集',
      // 可选颜色
      colors: [
        {color: '#b71c1c'},
        {color: '#4a148c'},
        {color: '#303f9f'},
        {color: '#006064'},
        {color: '#004d40'},
        {color: '#263238'},
        {color: '#212121'},
        {color: '#4e342e'},
        {color: '#f57f17'},
        {color: '#33691e'}
      ],
      formData: {
        title: null,
        introduction: null,
        color: '#004d40',
        cover: null,
        cover_url: null
      }
    };
  },
  mounted () {
    if (this.type !== 'create') {
      this.getItem();
    }
  },
  methods: {
    // 上传图片
    uploadImg () {
      let file = this.$refs['uploadEle'].files[0];
      let formData = new FormData();
      formData.append('image', file, file.name);
      this.$http.post('ajax_upload_image', formData, {
        headers: {'Content-Type': 'multipart/form-data'}
      }).then(res => {
        this.formData.cover = res.data.image_hash;
        this.formData.cover_url = res.data.image_url;
      });
    },
    // 创建收藏集 || 修改收藏集
    async createCollection () {
      if (this.type === 'create') {
        await this.$http.post('collections', this.formData).then(res => {
          this.$store.dispatch('updateMe');
          this.$alert('创建成功!', 'primary');
        });
      } else {
        await this.$http.put('collections/' + this.$route.params.collection_id, this.formData).then(res => {
          this.$alert('修改成功!', 'primary');
          this.$emit('updateCCI');
        });
      }
      this.$emit('closeCMP');
    },
    // 获取收藏集详情
    getItem () {
      this.$http.get('collections/' + this.$route.params.collection_id).then(res => {
        this.formData = {
          title: res.data.data.title,
          introduction: res.data.data.introduction,
          color: res.data.data.color,
          cover_url: res.data.data.cover.url
        };
      });
    }
  }
};
</script>
<style lang="less">
.collect_edit_panel{
  min-width: 350px;
  width: 100%;
  position: relative;
  .mu-appbar{
    position: absolute;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
  }
  .edit_box{
    .cover{
      height: 260px;
      img{
        width: 100%;
        height: 260px;
      }
    }
    .content{
      color: #fff;
      padding: 20px;
      input{
        font-size: 25px;
      }
      input, textarea{
        width: 100%;
        border: none;
        line-height: 30px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.6);
        color: #fff;
        overflow-Y: hidden;
        outline: none;
        background: transparent;
      }
      textarea{
        max-height: 90px;
        overflow: auto;
        overflow-y: scroll;
        overflow-y: hidden;
      }
      .mu-text-field-help{
        color: #fff;
      }
      .mu-text-field-hint{
        color: rgba(255, 255, 255, 0.6);
      }
    }
    .color_select{
      padding: 20px;
    }
  }
} 
.active_color{
  background: rgba(0, 0, 0, 0.3);
}
</style>
