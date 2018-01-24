<template>
  <div class="tiny_panel">
    <span class="bot" :style="{transform: 'translateX(' + botOffset + 'px)'}"></span>
    <span class="top" :style="{transform: 'translateX(' + botOffset + 'px)'}"></span>
    <i @click="closeWindow()" class="material-icons close_window">close</i>
    <slot>
      <!-- 个人资料 -->
      <div v-if="templateType === 2" class="my_profile">
        <div class="my_profile_top clear_fixed">
          <div class="my_photo">
            <img src="../../assets/images/temp.jpg" alt="">
            <span>更改</span>
            <input type="file">
          </div>
          <div class="my_profile_text">
            <h3>朱雅琪</h3>
            <p>157****0566</p>
            <a>更多资料</a>
          </div>
        </div>
        <div class="my_profile_tool clear_fixed">
          <router-link :to="{name: 'login'}">切换账号</router-link>
        </div>
      </div>
    </slot>
  </div>
</template>
<script>
export default{
  props: {
    // 小面板箭头位置
    botOffset: 0,
    // 小面板的模板类型
    templateType: 0
  },
  methods: {
    // 关闭小面板
    closeWindow () {
      this.$parent.currentIcon = null;
    }
  }
};
</script>
<style lang="less" scoped>
.tiny_panel{
    width:350px; 
    padding: 10px 0 0 0;
    // border:1px solid #888; 
    border: 1px solid #ccc;
    background: #fff;
    position:relative;
    position: absolute;
    box-shadow: 0 1px 2px rgba(0,0,0,.2);
    right: 20px;
    // z-index: 10;
}
.tiny_panel>span{
    width:0; 
    height:0; 
    font-size:0; 
    overflow:hidden; 
    position:absolute;
}
.tiny_panel>span.bot{
    border-width:10px; 
    border-style:solid dashed dashed; 
    border-color: transparent transparent #ccc; 
    left:240px; 
    top: -20px;
}
.tiny_panel>span.top{
    border-width:10px; 
    border-style:solid dashed dashed; 
    border-color:transparent transparent #ffffff ; 
    left:240px; 
    top:-19px;
}    
.close_window{
  float: right;
  margin-right: 10px;
  font-size: 20px;
  &:hover{
    color: #ff5252;
  }
}
.my_profile{
  padding:20px 0 0 0;
  .my_profile_top{
    padding: 0 30px 20px;
    border-bottom: 1px solid #ccc;
    .my_photo{
      width: 90px;
      height: 90px;
      position: relative;
      border-radius: 50%;
      overflow: hidden;
      background: #4d90fe;
      img{
        width: 100%;
        height: 100%;
      }
      span{
        display: block;
        position: absolute;
        color: #fff;
        font-weight: bold;
        background: rgba(0, 0, 0, 0.5);
        bottom: 0;
        font-size: 12px;
        width: 100%;
        line-height: 25px;
        text-align: center;
      }
      input{
        width: 100%;
        height: 100%;
        background: red;
        position: absolute;
        top: 0;
        opacity: 0;
      }
    }
    .my_profile_text, .my_photo{
      float: left;
    }
    .my_profile_text{
      margin-left: 20px;
      padding-top: 5px;
      h3{
        color: #000;
      }
      h3,p{
        line-height: 25px;
        font-size: 15px;
      }
      p{
        font-size: 14px;
      }
      a{
        margin-top: 5px;
        display: block;
        width: 70px;
        padding: 2px 0;
        text-align: center;
        background: #4d90fe;
        border: 1px solid #3079ed;
        color:#fff;
        font-size: 12px;
        border-radius: 2px;
        line-height: 20px;
      }
      a:hover{
        background: #3884fd;
      }
    }
  }
  .my_profile_tool{
    background: #f5f5f5;
    padding: 7px 10px;
    a{
      font-size: 12px;
      display: block;
      width: 70px;
      line-height: 20px;
      float: right;
      text-decoration: none;
      padding: 5px 7px;
      background: #f8f8f8;
      border: 1px solid #c6c6c6;
      color: #666;
      transition: background 0.5s;
      &:hover{
        background: #fefefe;
      }
    }
  }
}
</style>
