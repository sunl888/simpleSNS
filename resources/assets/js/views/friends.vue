<template>
<div>
  <mu-dropDown-menu :value="value" @change="handleChange">
    <mu-menu-item value="1" title="我关注的"/>
    <mu-menu-item value="2" title="关注我的"/>
  </mu-dropDown-menu>
  <div class="peroson-card-list">
    <person-card v-for="x in 10" :key="x"></person-card>
  </div>
</div>
</template>
<script>
import PersonCard from '../components/PersonCard/PersonCard.vue';
export default {
  components: {
    PersonCard
  },
  data () {
    return {
      item: [],
      value: '1'
    };
  },
  computed: {
    me () {
      return this.$store.state.me === null ? null : this.$store.state.me;
    }
  },
  mounted () {
    this.getFollowing();
  },
  methods: {
    handleChange (value) {
      this.value = value;
    },
    getFollowing () {
      this.$http.get('user/5/following').then(res => {
        console.log(this.$store.state.me);
      });
    }
  }
};
</script>
<style lang="less">
  .peroson-card-list{
    margin-top: 10px;
  }
</style>
