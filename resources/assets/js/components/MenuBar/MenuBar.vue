<template>
<div>
  <div v-if="menuStyle === 'big'" class="menu_bar animated slideInLeft" :class="{'slideOutLeft' : showMenu === false}">
    <mu-menu>
      <mu-menu-item title="首页"  :to="{name: 'home'}" leftIcon="home"/>
      <mu-menu-item title="发现" :to="{name: 'find'}" leftIcon="explore"/>
      <mu-menu-item title="个人资料" :to="{name: 'me'}" leftIcon="account_circle"/>
      <mu-menu-item title="人脉" :to="{name: 'friends'}" leftIcon="group"/>
      <mu-menu-item title="通知" :to="{name: 'notice'}" leftIcon="notifications"/>
      <mu-divider />
      <!-- <mu-menu-item title="设置"/> -->
      <mu-menu-item :to="{name: 'feekback'}" title="联系我们"/>
      <!-- <mu-menu-item title="帮助"/> -->
    </mu-menu>
  </div>
  <mu-drawer v-else :open="showMenu" :docked="docked" @close="toggle()">
    <mu-appbar title="Simple SNS"/>
    <mu-menu>
      <mu-menu-item title="首页"  :to="{name: 'home'}" leftIcon="home"/>
      <mu-menu-item title="发现" :to="{name: 'find'}" leftIcon="explore"/>
      <mu-menu-item title="个人资料" :to="{name: 'profile'}" leftIcon="person_pin"/>
      <mu-menu-item title="人脉" :to="{name: 'friends'}" leftIcon="person_pin"/>
      <mu-menu-item title="通知" :to="{name: 'notice'}" leftIcon="notifications"/>
      <mu-divider />
      <!-- <mu-menu-item title="设置"/> -->
      <mu-menu-item :to="{name: 'feekback'}" title="联系我们"/>
      <!-- <mu-menu-item title="帮助"/> -->
    </mu-menu>
  </mu-drawer>
</div>
</template>
<script>
export default {
  data () {
    return {
      docked: false
    };
  },
  props: {
    menuStyle: String,
    showMenu: false
  },
  methods: {
    toggle () {
      this.$emit('closeMenu');
    }
  },
  mounted () {
    // this.toggle();
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
