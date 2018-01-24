<template>
  <div class="login">       
    <div class="photo">
      <img src="../../assets/images/temp.jpg" alt="">
    </div>
    <mu-row gutter>
      <mu-col  class="form clear_fixed" width="90" tablet="50" desktop="25">
        <h2>登录</h2>
        <mu-text-field hintText="请输入手机号" type="text" fullWidth v-model="userId"/><br/>
        <mu-text-field hintText="请输入密码" type="password" fullWidth v-model="userPassword"/><br/>
        <mu-checkbox label="记住我" class="demo-checkbox remeber_me"/>
        <div class="logon">
          <router-link :to="{name: 'forget_pass'}">忘记密码</router-link>
        </div>
        <mu-raised-button :to="{name: 'home'}" label="登录" class="demo-raised-button submit_btn" fullWidth primary/>
        <div class="oauth_login">
          <h3>第三方账号登录</h3> 
          <mu-icon-button class="oauth_btn">
            <i class="iconfont icon-qq-copy"></i>
          </mu-icon-button> 
          <mu-icon-button class="oauth_btn">
            <i class="iconfont icon-weixin-copy"></i>
          </mu-icon-button>
          <mu-icon-button class="oauth_btn">
            <i class="iconfont icon-433-github"></i>
          </mu-icon-button>
        </div>
        </mu-col>
    </mu-row>
  </div>
</template>
<script>
export default{
  data () {
    return {
      // 用户id
      userId: null,
      // 用户密码
      userPassword: null
    };
  }
};
</script>
<style lang="less" scoped>
 .form{
    .remeber_me{
      float: left;
    }
    .logon{
      float: right;
      a{
        color: #888;
        // float: right;
        cursor: pointer;
        &:hover{
          color: #20a0ff;
        }
      }
    }
    .oauth_login{
      width: 220px;
      padding: 20px 0;
      margin: 0 auto;
      h3{
        text-align: center;
        margin-bottom: 10px;
        color: #555;
      }
      .icon-qq-copy:before{
        color: #20a0ff;
      }
      .icon-weixin-copy:before{
        color: green;
      }
      .icon-433-github:before{
        margin-right: 0;
        color: #444;
      }
      .oauth_btn{
        width: 70px;
        height: 70px;
      }
      i{
        transition: opacity 0.3s;
        font-size: 35px;
        cursor: pointer;    
        opacity: 0.5;  
        &:hover{
          opacity: 1;
        }
      }
    }
  }
</style>