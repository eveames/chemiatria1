<template>
<div>
  <example></example>
  <test1></test1>
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
      currentQuestionState: 'getCurrent'
    })
  },
  created () {
    Promise.all([this.$store.dispatch('setupWords'),
    this.$store.dispatch('setupStates')])
    //this.$store.dispatch('setupFacts')])
    .then((results) => {
      console.log(results);
      console.log('promise resolved, in then')
      this.$store.dispatch('setReady')
      let curr = this.currentQuestionState;
      console.log("curr is ", curr)
      this.$store.dispatch('setQuestion', curr)
    })

  }
}
</script>
