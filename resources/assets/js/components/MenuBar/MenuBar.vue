<template>
  <mu-popup ref="popup" position="left" :overlay="false" popupClass="menu_bar" :open="show">
    <mu-menu>
      <mu-menu-item title="首页" leftIcon="home"/>
      <mu-menu-item title="发现" leftIcon="explore"/>
      <mu-menu-item title="个人资料" leftIcon="person_pin"/>
      <mu-menu-item title="人脉" leftIcon="person_pin"/>
      <mu-menu-item title="通知" leftIcon="notifications"/>
      <mu-divider />
      <mu-menu-item title="设置"/>
      <mu-menu-item title="联系我们"/>
      <mu-menu-item title="帮助"/>
    </mu-menu>
  </mu-popup>
</template>
<script>
export default {
  data () {
    return {
      show: true
    };
  },
  methods: {
  }
};
</script>
<style lang="less">
.menu_bar {
  display: flex;
  height: calc(~"100% - 80px");
  // align-items: center;
  padding: 0px 20px 20px 20px;
  margin-top: 40px;
  background: transparent;
}
</style>
