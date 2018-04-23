<template>
  <mu-paper class="feekback clear_fixed">
    <mu-text-field v-model="content" hintText="请说明您的问题与想法" multiLine :rows="16" fullWidth/>
    <mu-flat-button @click="submitFeekback" class="submit_btn">提交</mu-flat-button>
  </mu-paper>
</template>
<script>
export default {
  data () {
    return {
      content: ''
    };
  },
  methods: {
    submitFeekback () {
      this.$http.post('feedback', {
        // content: this.content
      }).then(res => {
        console.log(res);
      });
    }
  }
};
</script>
<style lang="less">
.feekback{
  padding: 30px;
  .submit_btn{
    float: right;
  }
}
</style>

