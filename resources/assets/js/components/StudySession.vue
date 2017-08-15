<template>
<div>
  <word-question v-if="ready === true && currentQuestionState[2] === 'word'">
  </word-question>
  <fact-question v-if="ready === true && currentQuestionState[2] === 'fact'">
  </fact-question>
  <bug-report></bug-report><frustration-report></frustration-report><suggestion-box></suggestion-box>
</div>
</template>
<style>
</style>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      wordsStatus: 'checkWordsReady',
      factsStatus: 'checkFactsReady',
      statesStatus: 'checkStatesReady',
      currentQuestionState: 'getCurrent',
      setupReady: 'checkSetup'
    }),
    ready () {
      if(this.setupReady === true && typeof(this.currentQuestionState) !== 'undefined') {
        return true;
      }
      else return false;
    }
  },
  created () {
    Promise.all([this.$store.dispatch('setupWords'),
    this.$store.dispatch('setupStates'),
    this.$store.dispatch('setupFacts')])
    .then((results) => {
      //console.log(results);
      //console.log('promise resolved, in then')
      this.$store.dispatch('setReady')
      let curr = this.currentQuestionState;
      this.$store.dispatch('setQuestionStart');
    })

  }
}
</script>
