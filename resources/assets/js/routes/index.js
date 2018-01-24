import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);
// 判断当前路由是否为后退行为
Router.prototype.goBack = function () {
  this.isBack = true;
  window.history.go(-1);
};
// const parentComponent = {template: '<router-view></router-view>'};
export default new Router({
  routes: [
    {
      path: '*',
      redirect: { name: 'home' }
    },
    // 登录
    {
      path: '/login',
      meta: { title: '首页' },
      component: require('../views/account/AccountComponent.vue'),
      children: [
        {
          path: '/',
          name: 'login',
          component: require('../views/account/login.vue')
        },
        {
          path: '/forget_pass',
          name: 'forget_pass',
          component: require('../views/account/forgetPass.vue')
        }
      ]
    },
    {
      path: '/logon',
      name: 'logon',
      component: require('../views/account/login.vue')
    },
    // 首页
    {
      path: '/home',
      name: 'home',
      component: require('../views/home.vue')
    }
  ]
});
