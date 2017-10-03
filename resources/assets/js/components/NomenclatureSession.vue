<template>
<div>
  <div>Easy mode talks you through the decisions you need to make. Hard mode just asks for the answer.
    Currently set to {{mode}}</div>
  <button @click="setMode()" class="btn btn-default"
    type="button">Set {{notMode}}</button>
  <div v-show="finished" class="alert alert-success">
    <strong>Congrats, you've finished studying everything you set for this session!</strong>
    Add more material by returning to your dashboard and setting a new session, or
    check back in later to see if you have material to review. Or just keep studying, if you want.</div>
    <div v-show="message" class="alert alert-info">
      {{message}}</div>
  <div v-if="ready === false">Please wait, loading</div>
  <div class="alert alert-danger" v-if="ready === true && currentQuestionState[0] === -1">
    You haven't set up nomenclature! Please return to your dashboard and use Setup New Session
    to add the topic nomenclature.</div>
  <general-nomenclature-question v-if="ready === true && currentQuestionState[2] === 'skill'" :easymode='modeBool'>
  </general-nomenclature-question>

  <div>
  <button @click="$store.dispatch('toggleBug')" class="btn btn-default"
    type="button" v-show="!bug">Report Bug</button>
  <button @click="$store.dispatch('toggleFrustrated')" class="btn btn-default"
    type="button" v-show="!frustrated">I'm frustrated</button>
  <button @click="$store.dispatch('toggleSuggestion')" class="btn btn-default"
    type="button" v-show="!suggestion">Make a suggestion</button>
  </div>
  <bug-report v-if="bug"></bug-report><frustration-report v-if="frustrated"></frustration-report>
  <suggestion-box v-if="suggestion"></suggestion-box>
  <hr>
</div>
</template>
<style>
</style>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data: function() {
    return {
      mode: 'Easy Mode',
      notMode: 'Hard Mode',
      modeBool: true,
    }
  },
  computed: {
    ...mapGetters({
      factsStatus: 'checkFactsReady',
      statesStatus: 'checkStatesReady',
      currentQuestionState: 'getCurrent',
      setupReady: 'checkSetup',
      finished: 'getFinished',
      frustrated: 'isFrustrated',
      bug: 'isBug',
      suggestion: 'hasSuggestion',
      message: 'getMessage',
    }),
    ready () {
      if(this.setupReady === true && typeof(this.currentQuestionState) !== 'undefined') {
        return true;
      }
      else return false;
    }
  },
  created () {
    Promise.all([this.$store.dispatch('setupFacts')])
    .then((results) => {this.$store.dispatch('setupStates', 9)})
    .then((results) => {this.$store.dispatch('setupIons')})
    .then((results) => {

      console.log(results);
      console.log('promise resolved, in then')
      this.$store.dispatch('setReady')
      let curr = this.currentQuestionState;
      console.log(curr)
      this.$store.dispatch('setQuestionStart');
    })


  },
  methods: {
    setMode() {
      console.log('called setMode')
      if (this.modeBool) {
        this.mode = 'Hard Mode'
        this.notMode = 'Easy Mode'
      }
      else {
        this.notMode = 'Hard Mode'
        this.mode = 'Easy Mode'
      }
      this.modeBool = !this.modeBool
    }
  }
}
</script>
