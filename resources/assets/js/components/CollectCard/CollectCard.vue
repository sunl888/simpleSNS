<template>
  <mu-flexbox :style="{background : color}" @click.native="$router.push({name: 'collection', params: {collection_id: value}})" class="collect_card" orient="vertical">
    <mu-flexbox-item class="collect_top">
      <img :src="cover">
    </mu-flexbox-item>
    <mu-flexbox-item class="my_photo">
      <img :src="avator">
    </mu-flexbox-item>
    <mu-flexbox-item class="collect_bottom clear_fixed">
      <h3>{{title}}</h3>
      <mu-raised-button @click.native.stop="orderCollection" class="order_collection">{{isSubscribe === false ? '订阅' : '取消订阅'}}</mu-raised-button>
    </mu-flexbox-item>
  </mu-flexbox>
</template>
<script>
export default{
  props: {
    cover: String,
    avator: String,
    title: String,
    color: String,
    value: Number,
    isSubscribe: Boolean
  },
  methods: {
    // 订阅收藏集
    orderCollection () {
      // this.isSubscribe = !this.isSubscribe;
      this.$http.post('collections/' + this.value + '/subscribe').then(res => {
        if (this.isSubscribe) {
          this.$alert('已经取消订阅收藏集《 ' + this.title + ' 》', 'primary');
        } else {
          this.$alert('已经成功订阅收藏集《 ' + this.title + ' 》', 'primary');
        }
        this.$store.dispatch('updateMe');
      });
    },
  }
};
</script>
<style lang="less">
.collect_card{
  width: 100%;
  height: 250px;
  // min-height: 280px;
  background: #ddd; 
  position: relative;
  min-width: 150px;
  padding: 0 0 10px 0;
  border-radius: 5px;
  margin: 0 0 40px 0;
  overflow: hidden;
  box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.2);
  .collect_top{
    height: 55%;
  }
  .collect_top>img{
    width: 100%;
    height: 100%;
  }
  .my_photo{
    position: absolute;
    width: 50px;
    height: 50px;
    overflow: hidden;
    top: 50%;
    transform: translateY(-50%);
    left: 20px;
    border-radius: 50%;
    border: 2px solid #fff;
    &>img{
      width: 100%;
      height: 100%;
    }
  }
  .collect_bottom{
    padding: 40px 20px;
    margin-top: -8px!important;
    .mu-raised-button{
      min-width: 70px;
    }
    &>h3{
      color: #fff;
      font-size: 17px;
      font-weight: normal;
    }
    &>p{
      color: #ccc;
    }
  }
  .order_collection{
    // float: right;
    margin-top: 10px;
    // margin-right: 5px;
  }
}
</style>
