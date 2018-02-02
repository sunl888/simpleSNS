<template>
<div v-if="isCreatePanel" class="mask">
  <mu-paper position="bottom" overlay class="demo-popup-bottom clear_fixed">
    <mu-appbar>
     <div class="my_photo">
        <span v-if="me.avatar === null">{{me.nickname.substr(0, 1)}}</span>
        <strong>{{me.nickname}}</strong>
        <!-- <img v-else :src="me.avatar.data.url" alt="">   -->
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
    <textarea placeholder="有什么新鲜事要分享吗" class="type_words"></textarea>
    <div class="text_bar">
      <mu-icon-button icon="photo_camera"/>
      <mu-icon-button icon="link"/>
    </div>
    <div class="operation_btn">
      <mu-flat-button @click="closeCreatePanel" label="取消" class="demo-flat-button"/>
      <mu-raised-button label="发布" class="demo-raised-button"/>
    </div>
  </mu-paper>
</div>
</template>
<script>
export default{
  data () {
    return {
      // 是否显示分享面板
      isCreatePanel: false,
      leftTop: {horizontal: 'left', vertical: 'top'}
    };
  },
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
  mounted () {
  },
  methods: {
    closeCreatePanel () {
      this.isCreatePanel = false;
    }
  }
};
</script>
<style lang="less">
.mask{
  width: 100%;
  height: 100%;
  padding: 50px 400px;
  position: fixed;
  overflow: auto;
  top: 0;
  z-index: 11;
  left: 0;
  background: rgba(0, 0, 0, 0.6);
}
.demo-popup-bottom{
  width: 55%;
  padding-bottom: 10px;
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 12;
  transform: translate(-50%, -50%);
  .my_photo{
    span,strong{
      float: left;
    }
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
    &>strong{
      font-size: 15px;
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
    min-height: 150px;
    outline: none;
    padding: 0 20px 20px;
    resize: none;
    width: 100%;
  }
  .text_bar{
    border-bottom: 1px solid #eee;
    padding: 0 5px;
    .mu-icon-button{
    }
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
