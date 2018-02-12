<template>
  <mu-paper>
    <mu-list>
        <mu-list-item v-for="(value, index) in item" :title="value.data.message" :key="index">
          <span class="created"><i class="material-icons">access_time</i>{{value.created_at.slice(0, value.created_at.indexOf('T'))}}</span>
          <mu-icon v-if="value.read_at === null" @click="setAlread(value.id)" title="设为已读" slot="right" value="done"/>
          <span v-else slot="right">已读</span>
        </mu-list-item>
    </mu-list>
  </mu-paper>
</template>
<script>
export default{
  data () {
    return {
      item: []
    };
  },
  mounted () {
    this.getNotice();
  },
  methods: {
    // 获取通知
    getNotice () {
      this.$http.get('notifications').then(res => {
        this.item = res.data.data;
      });
    },
    // 设为已读
    setAlread (id) {
      this.$http.patch('notifications/read/' + id).then(res => {
        this.$alert('已经设为已读', 'primary');
        this.getNotice();
      });
    }
  }
};
</script>
<style lang="less">
  .created{
    padding: 10px 0 0 0;
    font-size: 14px;
    color: #444;
    display: block;
    i{
      float: left;
      line-height: 20px;
      font-size: 16px;
      margin-right: 5px;
    }
  }
</style>
