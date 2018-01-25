<template>
<div class="login">
  <div v-if="$route.name === 'forget_pass'" class="photo">
    <img src="../../assets/images/temp.jpg" alt="">
  </div>
  <mu-row v-if="$route.name === 'forget_pass'" gutter>
    <mu-col class="form clear_fixed" width="90" tablet="50" desktop="30">
       <h2>找回密码</h2>
      <mu-text-field icon="phone" hintText="请输入手机号" type="text" fullWidth v-model="forgetPassData.userId"/>
      <mu-text-field icon="comment" class="vaild_code" hintText="请输入短信验证码" type="text" v-model="forgetPassData.vaildCode"/>
      <mu-raised-button :disabled="isValidCode" :label="validText" @click="getAgain()" class="demo-raised-button get_vaild_code"/>
      <mu-text-field icon="lock" hintText="请输入新密码" type="password" fullWidth v-model="forgetPassData.newPassword"/>
      <mu-text-field icon="lock" hintText="请重复输入新密码" type="password" fullWidth v-model="forgetPassData.confirmPassword"/>
      <mu-raised-button :to="{name: 'home'}" label="确定" class="demo-raised-button submit_btn" fullWidth primary/>
    </mu-col>
  </mu-row>
  <mu-row v-else gutter>
    <mu-col class="form clear_fixed" width="90" tablet="50" desktop="30">
       <h2>注册</h2>
      <mu-text-field icon="phone" hintText="请输入手机号" type="text" fullWidth v-model="registerData.userId"/>
      <mu-text-field icon="comment" class="vaild_code" hintText="请输入短信验证码" type="text" v-model="registerData.vaildCode"/>
      <mu-raised-button :disabled="isValidCode" :label="validText" @click="getAgain()" class="demo-raised-button get_vaild_code"/>
      <mu-text-field icon="lock" hintText="请输入新密码" type="password" fullWidth v-model="registerData.newPassword"/>
      <mu-text-field icon="lock" hintText="请重复输入新密码" type="password" fullWidth v-model="registerData.confirmPassword"/>
      <mu-raised-button :to="{name: 'home'}" label="确定" class="demo-raised-button submit_btn" fullWidth primary/>
    </mu-col>
  </mu-row>
</div>  
</template>
<script>
export default{
  data () {
    return {
      // 获取验证码是否可用
      isValidCode: false,
      // 验证码按钮文字
      validText: '获取验证码',
      // 表单数据
      forgetPassData: {
        // 手机号
        userId: null,
        // 验证码
        vaildCode: null,
        // 新密码
        newPassword: null,
        // 验证密码
        confirmPassword: null
      },
      registerData: {
        // 手机号
        userId: null,
        // 验证码
        vaildCode: null,
        // 新密码
        newPassword: null,
        // 验证密码
        confirmPassword: null
      }
    };
  },
  methods: {
    getAgain () {
      if (this.forgetPassData.userId === null || this.registerData.userId === null) {
        this.$alert('要先输入手机号哦', 'error');
      } else if (!this.isValidCode) {
        let i = 60;
        let timer = window.setInterval(() => {
          this.isValidCode = true;
          i--;
          this.validText = i + 's后再次获取';
          if (i < 1) {
            this.isValidCode = false;
            this.validText = '获取验证码';
            clearInterval(timer);
          }
        }, 1000);
      }
    }
  }
};
</script>
<style lang="less" scoped>
.form{
  .vaild_code, .get_vaild_code{
    float: left;
  }
  .vaild_code{
    width: 55%;
    margin-right: 5%;
  }
  .get_vaild_code{
    width: 40%;
    font-size: 12px!important;
  }
}
</style>
