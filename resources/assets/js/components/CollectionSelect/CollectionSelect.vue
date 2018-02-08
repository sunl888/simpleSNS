<template>
  <mu-paper class="collection_select">
    <mu-flexbox orient="vertical">
      <mu-flexbox-item>
        <mu-appbar title="选择收藏集">
          <mu-icon-button @click="$emit('closeCS', collection)" icon="keyboard_backspace" slot="left"/>
          <!-- <mu-flat-button @click="$emit('closeCS', collection)" slot="right">确定</mu-flat-button> -->
        </mu-appbar>
      </mu-flexbox-item>
      <mu-flexbox-item class="collects">
        <mu-radio @change="collection = value" v-model="collection.title" v-for="(value, index) in me.collections.data" :key="index" :nativeValue="value.title" :label="value.title" name="collection" class="demo-radio"/>
        <mu-radio name="collection" @change="$emit('openCMP')" nativeValue="create" label="新建收藏集"/>
      </mu-flexbox-item>
    </mu-flexbox>
  </mu-paper>
</template>
<script>
export default {
  components: {
  },
  computed: {
    me () {
      return this.$store.state.me === null ? {} : this.$store.state.me;
    }
  },
  data () {
    return {
      collection: {
        title: null
      },
      isCreatePanel: false
    };
  },
  methods: {
  }
};
</script>
<style lang="less">
.collection_select{
  width: 100%;
  max-height: 600px;
  overflow: auto;
  .collects{
    padding: 0 20px 20px;
    .mu-radio{
      margin: 10px 0;
      width: 100%;
    }
  }
}
</style>
