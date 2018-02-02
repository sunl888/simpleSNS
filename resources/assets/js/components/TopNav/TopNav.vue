<template>
<mu-appbar class="top_nav clear_fixed" title="Title">
  <mu-icon-button @click="expendMenu()" class="menu_btn" icon="menu" slot="left"/>
    <div class="logo clear_fixed">
      <h3>simple SNS</h3>
      <span>|</span>
      <span>{{$route.meta.title}}</span>
    </div>
    <search-tool></search-tool>
    <div v-if="isLogin" class="person_tool clear_fixed" slot="right">
      <div v-for="(value, index) in personInformation" :key="index">  
        <mu-icon-button @click="currentIcon = index" >
          <i :class="{'active_icon' : currentIcon === index}" class="material-icons">{{value.icon}}</i>
        </mu-icon-button>
        <tiny-panel v-if="currentIcon === index" :botOffset="index * 45" :templateType = "index">
        </tiny-panel>
      </div>
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
      // 顶部导航选中的小图标
      currentIcon: null,
      // 图标
      personInformation: [
        {icon: 'apps'},
        {icon: 'notifications'},
        {icon: 'face'}
      ]
    };
  },
  mounted () {
    // if (window.screen.width < 600) {
    //   this.isMenu = false;
    //   this.$parent.$children[1].$children[0].show = this.isMenu;
    // }
  },
  methods: {
    expendMenu () {
      // this.isMenu = !this.isMenu;
      this.$parent.$children[1].$children[0].$children[0].isMenu = !this.$parent.$children[1].$children[0].$children[0].isMenu;
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
    .person_tool>div{
      font-size: 28px;
      cursor: pointer;
      line-height: 70px;
      color: #666;
    }
    .menu_btn>.mu-icon-button:hover, .person_tool>i:hover{
      color: #000;
    }
    .person_tool>div{
      // position: relative;
      float: left;
    }
}
.active_icon{
  color: #20a0ff;
}
@media (max-width: 600px) {
  .search_tool{
    display: none;
  }
  .logo{
    span{
      display: none;
    }
  }
}
</style>

