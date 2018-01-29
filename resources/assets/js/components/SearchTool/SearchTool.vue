<template>
  <div class="search_tool clear_fixed">
      <i class="material-icons">search</i>
      <input type="text" @keyup.enter="searchData()" v-model="keyword" placeholder="搜索simple+">
      <i v-if="keyword !== null" @click="keyword = null" class="material-icons empty">highlight_off</i>
  </div>
</template>
<script>
export default{
  data () {
    return {
      // 搜索关键字
      keyword: null
    };
  },
  methods: {
    searchData () {
    }
  }
};
</script>
<style lang="less">
.search_tool{
    width: 100%;
    height: 50px;
    margin-top: 17px;
    float: left;
    background: #E5E5E5;
    border-radius: 3px;
    overflow: hidden;
    position: relative;
    i, input{
        float: left;
        color: #989898;
    }
    i{
        background: transparent;
        height: 100%;
        padding: 0 10px;
        box-sizing: content-box;
        line-height: 50px;
        display: block;
        text-align: center;
        cursor: pointer;
    }
    input{
	    width: calc(~"100% - 88px");
        height: 100%;
        border: none;
        outline: none;
        font-size: 16px;
        background: transparent;
    }
    
}
</style>
