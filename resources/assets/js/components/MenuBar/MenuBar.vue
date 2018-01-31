<template>
<div class="menu_bar animated slideInLeft" :class="{'slideOutLeft' : isMenu === true}">
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
</div>
</template>
<script>
export default {
  data () {
    return {
      isMenu: false
    };
  },
  methods: {
  }
};
</script>
<style lang="less">
.menu_bar {
  position: fixed;
  height: 100%;
  background: transparent;
  padding: 10px 20px 20px 10px;
}
</style>
