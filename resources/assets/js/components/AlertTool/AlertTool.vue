<template>
  <div>
    <mu-popup position="top" :overlay="false" :popupClass="type" :open="show">
      {{content}}
    </mu-popup>
  </div>
</template>
<script>
export default {
  data () {
    return {
      show: false,
      content: null,
      type: 'primary'
    };
  },
  mounted () {
    this.show = true;
    setTimeout(() => {
      this.show = false;
    }, 3000);
  },
  methods: {
    open () {
      this.show = true;
    }
  }
};
</script>
<style lang="less">
.primary, .warning, .error {
  width: 100%;
  opacity: .9;
  // height: 48px;
  color: #fff;
  padding: 5px 10px;
  line-height: 1.8em;
  display: flex;
  align-items: center;
  justify-content: center;
  // background: rgba(0, 0, 0, 0.8);
}
.primary{
  background: #20a0ff;
}
.warning{
  background: orange;
}
.error{
  background: #f44336;
}
</style>
