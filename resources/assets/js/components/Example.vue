<template>
<div>
  <h1 v-show=true>status is {{status}}</h1>
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
    computed: {
      word () {
        return this.$store.getters.getWordById(1)
      },
      ...mapGetters({
        status: 'checkWordsReady'
      })

    },
    methods: {
      checkUpdate: function(event) {
        this.count += 1;
        console.log("count is now " + this.count);
      }
    }
  }
</script>
