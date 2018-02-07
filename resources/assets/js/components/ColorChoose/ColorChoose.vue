<template>
  <mu-flat-button @click="onClick" class="color_choose_item" icon="bookmark" :style="{color: themeColor}"></mu-flat-button>
</template>
<script>
export default{
  props: {
    themeColor: String,
    value: String
  },
  data () {
    return {
      currentValue: null
    };
  },
  methods: {
    onClick () {
      this.currentValue = this.themeColor;
    }
  }
};
</script>
<style lang="less">
.color_choose_item{
  width: 40px;
  height: 40px;
  border-radius: 50%;
  min-width: 40px!important;
}
</style>
