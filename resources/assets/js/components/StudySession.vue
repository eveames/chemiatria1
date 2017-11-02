<template>
<div>
  <div class=""
  <div v-show="finished" class="alert alert-success">
    <strong>Congrats, you've finished studying everything you set for this session!</strong>
    Add more material by returning to your dashboard and setting a new session, or
    check back in later to see if you have material to review. Or just keep studying, if you want.</div>
    <div v-show="message" class="alert alert-info">
      {{message}}</div>
  <div v-if="ready === false">Please wait, loading</div>
  <div class="alert alert-danger" v-if="ready === true && currentQuestionState[0] === -1">
    You haven't chosen anything to study! Please return to your dashboard and use Setup New Session
    to select something.</div>
  <word-question v-if="ready === true && currentQuestionState[2] === 'word'">
  </word-question>
  <fact-question v-if="ready === true && currentQuestionState[2] === 'fact'">
  </fact-question>
  <skill-question v-if="ready === true && currentQuestionState[2] === 'skill'">
  </skill-question>
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
  <svg class="Lewis-Box-Sizes" width="20" height="20">
    <text v-for="element in elements" :id="'atomForBox' + element[0]" :x="0" :y="0" font-family="Verdana"
      font-size="24">{{element[0]}}</text>
  </svg>
  <hr>
</div>
</template>
<style>
</style>
<script>
import { mapGetters, mapActions } from 'vuex'
import _ from "lodash";

export default {
  computed: {
    ...mapGetters({
      wordsStatus: 'checkWordsReady',
      factsStatus: 'checkFactsReady',
      statesStatus: 'checkStatesReady',
      currentQuestionState: 'getCurrent',
      setupReady: 'checkSetup',
      finished: 'getFinished',
      frustrated: 'isFrustrated',
      bug: 'isBug',
      suggestion: 'hasSuggestion',
      message: 'getMessage',
      elements: 'getLSE',
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
    this.$store.dispatch('setupFacts'),
    this.$store.dispatch('setupSkills')])
    .then((results) => {this.$store.dispatch('setupStates', false)})
    .then((results) => {this.$store.dispatch('setupIons')})
    .then((results) => {

      console.log(results);
      console.log('promise resolved, in then')
      this.$store.dispatch('setReady')
      let curr = this.currentQuestionState;
      this.$store.dispatch('setQuestionStart');
    })

  },
  mounted () {
    setTimeout(() => {
      let boxArray = {}
      let rect = 0
      let width = 0
      let height = 0
      console.log("this.elements: ", this.elements)
      _.forOwn(this.elements, (element, key) => {
        rect = document.getElementById('atomForBox' + key).getBBox();
        width = rect.width;
        height = rect.height;
        boxArray[key] = {width: width, height: height}
      })
      this.$store.dispatch('setupBBoxes', boxArray)
    }, 10)
  }
}
</script>
