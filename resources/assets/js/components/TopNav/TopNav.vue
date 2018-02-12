<template>
<mu-appbar class="top_nav clear_fixed" title="Title">
  <mu-icon-button @click="expendMenu()" class="menu_btn" icon="menu" slot="left"/>
    <div class="logo clear_fixed">
      <h3>simple SNS</h3>
      <span>|</span>
      <span>{{$route.meta.title}}</span>
    </div>
    <search-tool></search-tool>
    <div v-if="isLogin === true" class="person_tool clear_fixed" slot="right">
      <mu-badge v-if="unreadCount !== 0" @click.native="$router.push({name: 'notice'})" :content="String(unreadCount)" circle secondary>
        <mu-icon-button icon="notifications"/>
      </mu-badge>
      <mu-icon-button v-else @click.native="$router.push({name: 'notice'})" icon="notifications" />
      <mu-icon-button @click="isTinyPanel = true">
        <i :class="{'active_icon' : isTinyPanel === true}" class="material-icons">face</i>
      </mu-icon-button>
      <tiny-panel v-if="isTinyPanel"  @closeTP="isTinyPanel = false">
      </tiny-panel>
    </div>
    <div class="expect_style" v-else>
      <mu-raised-button :to="{name: 'register'}"  label="注册" class="demo-raised-button"/>
      <mu-raised-button :to="{name: 'login'}"  label="登录" class="demo-raised-button" primary/>
    </div>
</mu-appbar>
</template>
<script>
// 搜索框组件
import SearchTool from '../SearchTool/SearchTool.vue';
// 小面板组件
import TinyPanel from '../TinyPanel/TinyPanel.vue';
import { isLogin } from '../../utils/utils';
export default{
  components: {
    SearchTool,
    TinyPanel
  },
  data () {
    return {
      // 判断是否登录
      isLogin: isLogin(),
      // 是否显示菜单
      isMenu: true,
      // 是否打开小窗口
      isTinyPanel: false,
      // 未读通知数量
      unreadCount: 0,
      // 图标
      personInformation: [
        {icon: 'apps'},
        {icon: 'notifications'},
        {icon: 'face'}
      ]
    };
  },
  mounted () {
    this.isLogin = isLogin();
    this.getNoticeCount();
  },
  methods: {
    expendMenu () {
      this.$parent.isMenu = !this.$parent.isMenu;
    },
    // 获取未读消息
    getNoticeCount () {
      this.$http.get('notifications/unread_count').then(res => {
        this.unreadCount = res.data.unread;
      });
    }
  }
};
</script>
<style lang="less">
.top_nav{
    width: 100%;
    height: 70px;
    background: #fff;
    .menu_btn{
      color: #444;
      float: left;
      margin: 0 15px 0 15px;
    }
    .expect_style{
      float: right;
      margin: 20px 0 0 0;
      .mu-raised-button{
        margin-left: 10px;
        min-width: 60px;
        font-size: 14px;
      }
    }
    .logo{
      float: left;
      margin: 0 15px;
      h3, span{
        color: #666;
      }
      h3,span{
        margin-right: 20px;
        font-size: 18px;
        float: left;
        line-height: 80px;
      }
    }
    .search_tool{
      width: 50%;
    }
    .person_tool{
      margin-right: 15px;
    }
    .person_tool{
      font-size: 28px;
      cursor: pointer;
      line-height: 70px;
      color: #666;
    }
    .menu_btn>.mu-icon-button:hover, .person_tool>i:hover{
      color: #000;
    }
    .person_tool{
      // position: relative;
      float: left;
      .mu-badge{
        margin-left: -8px;
      }
      .mu-badge-float{
        top: 6px;
      }
    }
}
.active_icon{
  color: #20a0ff;
}
@media (max-width: 800px) {
  .search_tool{
    display: none;
  }
  .logo{
    span{
      // display: none;
    }
    h3{
      // display: none;
    }
  }
  @media (max-width: 520px) {
    .logo{
      h3{
        display: none;
      }
    }
  }
}
</style>

