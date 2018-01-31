<template>
  <mu-paper class="demo-paper clear_fixed" :zDepth="1">
    <div class="article_photo">
      <span v-if="me.avatar === null">{{me.nickname.substr(0, 1)}}</span>
      <!-- <img v-else :src="me.avatar.data.url">   -->
    </div>
    <input @focus="open_create_panel" type="text" class="article_input" placeholder="有什么新鲜事要分享吗"/>
    <mu-icon-button class="select_photo" icon="photo_camera"/>
  </mu-paper>
</template>
<script>
export default{
  data () {
    return {
    };
  },
  computed: {
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
  mounted () {
  },
  methods: {
    open_create_panel () {
      this.$root.$children[0].$children[0].$children[2].isCreatePanel = true;
    }
  }
};
</script>
<style lang="less">
.demo-paper {
  // float: left;
  display: inline-block;
  width: 100%;
  margin-right: 10px;
  height: 70px;
  text-align: center;
}
.article_photo{
  width: 40px;
  height: 40px;
  background: #A0C3FF;
  margin: 15px 0 0 15px;
  border-radius: 50%;
  overflow: hidden;
  img{
    width: 100%;
    height: 100%;
  }
  span{
    font-size: 35px;
    line-height: 35px;
    display: block;
    text-align: center;
    color: #fff;
  }
}
.article_photo, .article_input{
  float: left;
}
.article_input{
  display: block;
  margin-top: 25px;
  margin-left: 10px;
  border: none;
  outline: none;
  font-size: 16px;
}
.select_photo{
  float: right;
  margin-top: 12px;
  margin-right: 15px;
  color: #888;
  background: #eee;
}
</style>
