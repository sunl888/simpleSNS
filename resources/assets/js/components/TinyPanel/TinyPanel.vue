<template>
    <div class="tiny_panel">
        <span class="bot" :style="{transform: 'translateX(' + botOffset + 'px)'}"></span>
        <span class="top" :style="{transform: 'translateX(' + botOffset + 'px)'}"></span>
        <i @click="closeWindow()" class="material-icons close_window">close</i>
        <slot></slot>
    </div>
</template>
<script>
export default{
    props: {
      // 小面板箭头位置
      botOffset: 0
    },
    methods: {
      closeWindow () {
        this.$el.style.display = "none";
      }
    }
}
</script>
<style lang="less" scoped>
.tiny_panel{
    width:300px; 
    padding: 10px;
    // border:1px solid #888; 
    border: 1px solid #ccc;
    background: #fff;
    position:relative;
    position: absolute;
    box-shadow: 0 1px 2px rgba(0,0,0,.2);
    right: 20px;
    // z-index: 10;
}
.tiny_panel span{
    width:0; 
    height:0; 
    font-size:0; 
    overflow:hidden; 
    position:absolute;
}
.tiny_panel span.bot{
    border-width:10px; 
    border-style:solid dashed dashed; 
    border-color: transparent transparent #ccc; 
    left:190px; 
    top: -20px;
}
.tiny_panel span.top{
    border-width:10px; 
    border-style:solid dashed dashed; 
    border-color:transparent transparent #ffffff ; 
    left:190px; 
    top:-19px;
}    
.close_window{
  float: right;
  font-size: 20px;
}
</style>
