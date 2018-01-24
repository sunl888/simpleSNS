<template>
  <div class="top_nav clear_fixed">
    <div class="menu_btn">
      <i class="material-icons">menu</i>
    </div>
    <div class="logo clear_fixed">
      <h3>simple SNS</h3>
      <span>|</span>
      <span>首页</span>
    </div>
    <search-tool></search-tool>
    <div class="person_tool clear_fixed">
      <div v-for="(value, index) in personInformation" :key="index">
        <i @click="currentIcon = index" :class="{'active_icon' : currentIcon === index}" class="material-icons">{{value.icon}}</i>
        <tiny-panel v-if="currentIcon === index" :botOffset="index * 40" :templateType = "index">
        </tiny-panel>
      </div>
    </div>
  </div>
</template>
<script>
import SearchTool from '../SearchTool/SearchTool.vue';
import TinyPanel from '../TinyPanel/TinyPanel.vue';
export default{
  components: {
    SearchTool,
    TinyPanel
  },
  data () {
    return {
      // 当前选中的小图标
      currentIcon: null,
      personInformation: [
        {icon: 'apps'},
        {icon: 'new_releases'},
        {icon: 'face'}
      ]
    };
  },
  methods: {
  }
};
</script>
<style lang="less">
.top_nav{
    width: 100%;
    height: 70px;
    background: #fff;
    .menu_btn>i{

    }
    .logo{
      float: left;
      margin: 0 15px;
      h3,span{
        margin-right: 20px;
        color: #666;
        font-size: 18px;
        float: left;
        line-height: 70px;
      }
    }
    .menu_btn>i{
        float: left;
        line-height: 70px;
    }
    .search_tool{
      width: 50%;
    }
    .person_tool{
      float: right;
      margin-right: 15px;
    }
    .menu_btn>i{
      margin-left: 30px;
    }
    .menu_btn>i, .person_tool>div{
      margin-right: 15px;
      font-size: 28px;
      cursor: pointer;
      line-height: 70px;
      color: #666;
    }
    .menu_btn>i:hover, .person_tool>i:hover{
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
</style>

