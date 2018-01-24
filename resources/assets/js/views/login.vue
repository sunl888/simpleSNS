<template>
<div class="login_box">
  <div class="login">
    <div class="photo">
      <img src="../assets/images/temp.jpg" alt="">
    </div>
    <mu-row gutter>
      <mu-col  class="form clear_fixed" width="90" tablet="50" desktop="33">
        <h2>登录</h2>
        <mu-text-field hintText="请输入手机号" type="text" fullWidth v-model="userId"/><br/>
        <mu-text-field hintText="请输入密码" type="password" fullWidth v-model="userPassword"/><br/>
        <mu-checkbox label="记住我" class="demo-checkbox remeber_me"/>
        <div class="logon">
          <router-link :to="{name: 'forget_pass'}">忘记密码</router-link>
          <span>|</span>
          <a>没有账号？</a>
        </div>
        <mu-raised-button label="登录" class="demo-raised-button login_btn" fullWidth primary/>
        <div class="oauth_login">
          <h3>第三方账号登录</h3>  
          <i class="iconfont icon-qq-copy"></i>
          <i class="iconfont icon-weixin-copy"></i>
          <i class="iconfont icon-433-github"></i>
        </div>
      </mu-col>
    </mu-row>
  </div>
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
<style lang="less">
body{
  background: url('../assets/images/01.jpg') no-repeat top center!important;
  background-size: cover;
}
.login{
  width: 100%;
  margin-top: 120px;
  padding: 10px 0;
  background: rgba(255, 255, 255, 0.9)!important;
  position: relative;
  box-shadow: 2px 1px 10px 1px #000;
  .photo{
    @size: 130px;
    width: @size;
    height: @size;
    border-radius: 50%;
    border: 5px solid #fff;
    overflow: hidden;
    position: absolute;
    left: 50%;
    top: -65px;
    transform: translateX(-50%);
    img{
      width: 100%;
      height: 100%;
    }
  }
  .form{
    // width:30%;
    margin: 0 auto;
    overflow: hidden;
    h2{
      margin: 70px 0 20px 0; 
      text-align: center;
    }
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
    .login_btn{
      margin: 15px 0;
    }
    .oauth_login{
      width: 210px;
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
      i{
        transition: opacity 0.3s;
        font-size: 40px;
        cursor: pointer;
        margin-right: 40px;      
        opacity: 0.5;  
        &:hover{
          opacity: 1;
        }
      }
    }
  }
}
</style>
