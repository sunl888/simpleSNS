import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);
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
        },
        {
          path: '/register',
          name: 'register',
          component: require('../views/account/forgetPass.vue')
        }
      ]
    },
    // 首页
    {
      path: '/home',
      component: require('../views/home.vue'),
      children: [
        {
          path: '',
          name: 'home',
          meta: {title: '首页'},
          component: require('../views/index.vue')
        },
        {
          path: 'find',
          name: 'find',
          meta: {title: '发现'},
          component: require('../views/find.vue')
        },
        {
          path: 'me',
          name: 'me',
          meta: { title: '个人资料' },
          component: require('../views/profile.vue')
        },
        {
          path: 'profile/:userId',
          name: 'profile',
          meta: { title: '个人资料' },
          component: require('../views/profile.vue')
        },
        {
          path: 'collection/:collection_id',
          name: 'collection',
          meta: {title: '收藏集'},
          component: require('../views/collection.vue')
        },
        {
          path: 'all_collections',
          name: 'all_collections',
          component: require('../views/all_collections.vue')
        },
        {
          path: 'notice',
          name: 'notice',
          meta: {title: '通知'},
          component: require('../views/notice.vue')
        },
        {
          path: 'friends',
          name: 'friends',
          meta: {title: '人脉'},
          component: require('../views/friends.vue')
        },
        {
          path: 'feekback',
          name: 'feekback',
          meta: {title: '反馈'},
          component: require('../views/feekback.vue')
        }
      ]
    }
  ]
});
