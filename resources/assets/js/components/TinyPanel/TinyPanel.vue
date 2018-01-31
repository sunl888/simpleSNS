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
            <span v-if="me.avatar === null">{{me.nickname.substr(0, 1)}}</span>
            <!-- <img v-else :src="me.avatar.data.url" alt="">   -->
            
            <!-- <span>更改</span> -->
            <input type="file">
          </div>
          <div class="my_profile_text">
            <h3>{{me.nickname}}</h3>
            <p>{{me.tel_num}}</p>
            <p>{{me.email}}</p>
            <a class="theme_btn">{{me.tel_num === null ? '完善资料' : '更多资料'}}</a>
          </div>
        </div>
        <div class="my_profile_tool clear_fixed">
          <router-link :to="{name: 'register'}">添加账号</router-link>
          <a @click="logout" :to="{name: 'login'}">退出</a>
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
  computed: {
    // 获取个人信息
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
  methods: {
    // 关闭小面板
    closeWindow () {
      this.$parent.$parent.currentIcon = null;
    },
    // 退出登录
    async logout () {
      await this.$http.get('auth/logout', {
        params: {
          token: localStorage.getItem('jwt_token')
        }
      });
      localStorage.removeItem('jwt_token');
      localStorage.removeItem('expiry_time');
      this.$store.commit('UPDATE_ME', null);
      this.$parent.$parent.isLogin = false;
      this.$alert('已经退出账号啦 ┭┮﹏┭┮', 'primary');
    }
  }
};
</script>
<style lang="less">
.tiny_panel{
    width:350px; 
    padding: 10px 0 0 0;
    border: 1px solid #ccc;
    background: #fff;
    position:relative;
    position: absolute;
    box-shadow: 0 1px 2px rgba(0,0,0,.2);
    right: 20px;
    z-index: 10;
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
    left:230px; 
    top: -20px;
}
.tiny_panel>span.top{
    border-width:10px; 
    border-style:solid dashed dashed; 
    border-color:transparent transparent #ffffff ; 
    left:230px; 
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
        font-size: 50px;
        color: #fff;
        text-align: center;
        display: block;
      }
      input{
        width: 100%;
        height: 100%;
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
      text-align: center;
      padding: 3px 0;
      text-decoration: none;
      background: #f8f8f8;
      border: 1px solid #c6c6c6;
      color: #666;
      transition: background 0.5s;
      &:first-child{
        float: left;
      }
      &:hover{
        background: #fefefe;
      }
    }
  }
}
</style>
