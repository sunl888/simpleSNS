<template>
  <mu-paper class="collect_create_panel clear_fixed">
    <h2>创建收藏集</h2>
    <mu-text-field fullWidth v-model="formData.name" hintText="名称"/>
    <mu-text-field fullWidth v-model="formData.content" hintText="个性宣言"/>
    <mu-select-field fullWidth v-model="formData.range" :labelFocusClass="['label-foucs']" label="公开范围">
      <mu-menu-item v-for="text,index in option" :key="index" :value="index" :title="text.label" icon="text.icon"/>
    </mu-select-field>
    <input id="color" type="color">
    <p>* 设定后将无法更改</p>
    <div class="operation_btn">
      <mu-flat-button @click="$emit('closeCMP')">取消</mu-flat-button>
      <mu-raised-button>创建</mu-raised-button>
    </div>
  </mu-paper>
</template>
<script>
export default{
  data () {
    return {
      // 菜单
      option: [
        {label: '公开', icon: 'public'},
        {label: '你的好友', icon: 'favorite'},
        {label: '仅限自己', icon: 'lock_outline'}
      ],
      formData: {
        // 名称
        name: '',
        // 公开范围
        range: '',
        // 个性宣言
        content: ''
      }
    };
  },
  methods: {
  }
};
</script>
<style lang="less">
.collect_create_panel{
  width: 50%;
  min-width: 350px;
  padding: 10px 30px;
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 12;
  transform: translate(-50%, -50%);
  h2{
    margin: 10px 0;
  }
  p{
    color: #888;
  }
  .operation_btn{
    float: right;
    .mu-raised-button{
      margin-left: 10px;
    }
  }
}
</style>
