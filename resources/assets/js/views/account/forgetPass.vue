<template>
<div class="login">
  <div class="photo">
    <img src="../../assets/images/temp.jpg" alt="">
  </div>
  <mu-row gutter>
    <mu-col class="form clear_fixed" width="90" tablet="50" desktop="25">
       <h2>找回密码</h2>
      <mu-text-field hintText="请输入手机号" type="text" fullWidth v-model="formData.userId"/>
      <mu-text-field class="vaild_code" hintText="请输入短信验证码" type="text" v-model="formData.vaildCode"/>
      <mu-raised-button :disabled="isValidCode" :label="validText" @click="getAgain()" class="demo-raised-button get_vaild_code"/>
      <mu-text-field hintText="请输入新密码" type="password" fullWidth v-model="formData.newPassword"/>
      <mu-text-field hintText="请重复输入新密码" type="password" fullWidth v-model="formData.confirmPassword"/>
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
      formData: {
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
      if (this.formData.userId === null) {
        alert('请先输入手机号码！');
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
