<template>
  <mu-paper class="collect_edit_panel">
    <mu-appbar :title="collect_edit_title">
      <mu-icon-button @click="$emit('closeCMP')" icon="close" slot="left"/>
      <mu-flat-button slot="right">保存</mu-flat-button>
    </mu-appbar>
    <div class="edit_box">
      <div class="cover">
        <img src="../../assets/images/bg.png" alt="">
        <mu-flat-button icon="photo_camera" class="demo-flat-button">
          <input ref="uploadEle" @change="uploadImg" type="file" class="file-button">
        </mu-flat-button>
      </div>
      <div :style="{background : currentTheme}" class="content">
        <mu-text-field v-model="formData.title" :underlineShow="false" hintText="名称" fullWidth></mu-text-field>
        <mu-text-field v-model="formData.introduction" :underlineShow="false" hintText="简介" fullWidth multiLine :rows="1" :maxLength="100"/>
      </div>
      <div class="color_select">
        <color-choose :class="{'active_color' : currentTheme === value.color}" @click.native="chooseColor(value.color)" v-for="(value, index) in colors" :key="index" :themeColor="value.color">
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
      // 当前选中的主题色
      currentTheme: '#4a148c',
      // 面板标题
      collect_edit_title: this.type === 'create' ? '添加收藏集' : '修改收藏集',
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
        color: this.currentTheme,
        cover: null
      }
    };
  },
  mounted () {
  },
  methods: {
    // 选择收藏集主题色
    chooseColor (val) {
      this.currentTheme = val;
    },
    // 上传图片
    uploadImg () {
      let file = this.$refs['uploadEle'].files[0];
      let formData = new FormData();
      formData.append('image', file, file.name);
      this.$http.post('ajax_upload_image', formData, {
        headers: {'Content-Type': 'multipart/form-data'}
      }).then(res => {
        // Vue.prototype.$http.defaults.baseURL = null;
        // this.$http.get('img/' + res.data.image_hash).then(res => {
        //   console.log(res);
        // })
        // })
      });
    }
  }
};
</script>
<style lang="less">
.collect_edit_panel{
  max-width: 350px;
  position: relative;
  .mu-appbar{
    position: absolute;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.5);
  }
  .edit_box{
    .cover{
      height: 260px;
      img{
        width: 100%;
        height: 260px;
      }
      .mu-flat-button{
        position: absolute;
        top: 180px;
        right: 20px;
        border-radius: 50%;
        width: 50px;
        min-width: 50px;
        height: 50px;
        color: #fff;
        background: rgba(0, 0, 0, 0.3);
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
        outline: none;
        background: transparent;
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
