<template>
  <div class="login">       
    <div class="photo">
      <img src="../../assets/images/temp.jpg" alt="">
    </div>
    <mu-row gutter>
      <mu-col  class="form clear_fixed" width="90" tablet="50" desktop="30">
        <h2>登录</h2>
        <mu-text-field icon="account_circle" hintText="请输入手机号" type="text" fullWidth v-model="formData.userId"/><br/>
        <mu-text-field icon="lock" hintText="请输入密码" type="password" fullWidth v-model="formData.userPassword"/><br/>
        <mu-checkbox label="记住我" class="demo-checkbox remeber_me"/>
        <div class="logon">
          <router-link :to="{name: 'forget_pass'}">忘记密码</router-link>
        </div>
        <mu-raised-button @click="login" label="登录" class="demo-raised-button submit_btn" fullWidth primary/>
        <div class="oauth_login">
          <h3>第三方账号登录</h3> 
          <mu-icon-button v-for="(values, index) in icons" class="oauth_btn" :key="index">
            <a :href="'/oauth/' + values.type"><i :class="values.icon"></i></a>          
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
      icons: [
        {icon: 'iconfont icon-qq-copy', type: 'qq'},
        {icon: 'iconfont icon-weixin-copy', type: 'weixin'},
        {icon: 'iconfont icon-433-github', type: 'github'}
      ],
      // 表单数据
      formData: {
        // 用户id
        userId: null,
        // 用户密码
        userPassword: null
      }
    };
  },
  created () {
    console.log(123);
  },
  methods: {
    // 登录
    async login () {
      await this.$http.post('auth/login', {
        username: this.formData.userId,
        password: this.formData.userPassword
      }).then(res => {
        localStorage.jwt_token = res.data.access_token;
      });
      this.$router.push({name: 'home'});
      this.$store.dispatch('updateMe');
    }
  }
};
</script>
<style lang="less" scoped>
 .form{
    .remeber_me{
      float: left;
      margin-left: 17px;
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
      // padding: 20px 0;
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