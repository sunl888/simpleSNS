<template>
  <mu-flexbox class="find" :gutter="10" wrap="wrap">
     <mu-flexbox-item>
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
     <mu-flexbox-item>
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
     <mu-flexbox-item>
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
    <mu-flexbox-item>
      <find-tiny-card v-for="x in 5" :key="x"></find-tiny-card>
    </mu-flexbox-item>
  </mu-flexbox>
</template>
<script>
import FindTinyCard from '../components/FindTinyCard/FindTinyCard.vue';
export default{
  components: {
    FindTinyCard
  }
};
</script>
<style lang="less">

</style>
