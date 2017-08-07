<template>
<div>
  <h1 v-show=true>{{randomString}}</h1>
  <div v-if="status">The first word is {{word.word}} which is {{word.prompts[0]}}</div>
  <div @click="checkUpdate">Checking for updates: {{count}}</div>
</div>
</template>
<style>
</style>
<script>
import { mapGetters } from 'vuex'

  export default {
    data: function() {
      return {
        count: 0,
      //status: false,
      }
    },
    props: ['status'],
    computed: {
      word () {
        return this.$store.getters.getWordById(1)
      },
      randomString () {
        return Vue.randomDigitString(8, 8);
      }

    },
    methods: {
      checkUpdate: function(event) {
        this.count += 1;
        //console.log("count is now " + this.count);
      }
    }
  }
</script>
