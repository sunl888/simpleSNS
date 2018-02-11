<template>
<div class="login">
  <div v-if="$route.name === 'forget_pass'" class="photo">
    <img src="../../assets/images/temp.jpg" alt="">
  </div>
  <mu-row v-if="$route.name === 'forget_pass'" gutter>
    <mu-col class="form clear_fixed" width="90" tablet="50" desktop="30">
       <h2>找回密码</h2>
      <mu-text-field icon="phone" hintText="请输入手机号" type="text" fullWidth v-model="formData.userId"/>
      <mu-text-field icon="comment" class="vaild_code" hintText="请输入短信验证码" type="text" v-model="formData.vaildCode"/>
      <mu-raised-button :disabled="isValidCode" :label="validText" @click="getVaildCode()" class="demo-raised-button get_vaild_code"/>
      <mu-text-field icon="lock" hintText="请输入新密码" type="password" fullWidth v-model="formData.newPassword"/>
      <mu-text-field icon="lock" hintText="请重复输入新密码" type="password" fullWidth v-model="formData.confirmPassword"/>
      <mu-raised-button @click="register" :to="{name: 'home'}" label="确定" class="demo-raised-button submit_btn" fullWidth primary/>
    </mu-col>
  </mu-row>
  <mu-row v-else gutter>
    <mu-col class="form clear_fixed" width="90" tablet="50" desktop="30">
       <h2>注册</h2>
      <mu-text-field icon="phone" hintText="请输入手机号" type="text" fullWidth v-model="formData.userId"/>
      <mu-text-field icon="comment" class="vaild_code" hintText="请输入短信验证码" type="text" v-model="formData.vaildCode"/>
      <mu-raised-button :disabled="isValidCode" :label="validText" @click="getVaildCode()" class="demo-raised-button get_vaild_code"/>
      <mu-text-field icon="lock" hintText="请输入密码" type="password" fullWidth v-model="formData.newPassword"/>
      <mu-text-field icon="lock" hintText="请重复输入密码" type="password" fullWidth v-model="formData.confirmPassword"/>
      <mu-raised-button @click="register" label="确定" class="demo-raised-button submit_btn" fullWidth primary/>
    </mu-col>
  </mu-row>
</div>  
</template>
<script>
export default{
  data () {
    return {
      // 表单错误提示
      inputErrorText: '',
      timer: null,
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
  mounted () {
    localStorage.clear();
    if (localStorage.i < 59) {
      this.vaildBtn();
    }
  },
  methods: {
    // 获取验证码
    getVaildCode () {
      localStorage.i = 60;
      if (localStorage.i < 60) {
        this.validText = localStorage.i + 's后再次获取';
      }
      if (this.formData.userId === null) {
        this.$alert('要先输入手机号哦', 'error');
      } else if (this.formData.userId.length !== 11) {
        this.$alert('请输入11位手机号码', 'error');
      } else if (!this.isValidCode) {
        let url = null;
        url = this.$route.name === 'register' ? 'user_register' : 'user_reset_pwd';
        this.$http.post('auth/send_sms_code', {
          tel_num: this.formData.userId,
          sms_template: url
        }).catch(() => {
          clearInterval(this.timer);
        });
        this.vaildBtn();
      }
    },
    // 验证码按钮
    vaildBtn () {
      this.timer = window.setInterval(() => {
        this.isValidCode = true;
        localStorage.i--;
        this.validText = localStorage.i + 's后再次获取';
        if (localStorage.i < 1) {
          this.isValidCode = false;
          this.validText = '获取验证码';
          clearInterval(this.timer);
        }
      }, 1000);
    },
    // 注册&忘记密码
    async register () {
      if (this.formData.newPassword !== this.formData.confirmPassword) {
        this.$alert('两次输入的密码不同', 'error');
      } else {
        let url = this.$route.name === 'register' ? 'register' : 'reset_password';
        await this.$http.post('auth/' + url, {
          tel_num: this.formData.userId,
          sms_verification_code: this.formData.vaildCode,
          password: this.formData.newPassword
        }).then(res => {
          localStorage.setItem('jwt_token', res.data.access_token);
        });
        await this.$store.dispatch('updateMe');
        this.$router.push({name: 'home'});
        clearInterval(this.timer);
        localStorage.removeItem('i');
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
