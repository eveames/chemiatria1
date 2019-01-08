<template>
  <div class="panel panel-default">
      <div class="panel-heading">Lewis Structure Practice</div>

        <div class="panel-body">
          <div>
            Instructions: Enter y or n. By "good structure", I mean the best (or among the best) Lewis
            structures for the formula given.
            <br><br>
            Is this a good Lewis structure for <span v-html="this.$options.filters.formatFormula(formula)"></span>?</div>
            <div class="input-group">
              <input v-focus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control" autocorrect="off">
              <span class="input-group-btn">
                <button @click="submitEntry" class="btn btn-default"
                  type="button">Submit answer!</button>
              </span>
            </div>
            <div v-if="followup">
              <div>Instructions: Click on each thing that's wrong with the structure, then hit enter.</div>
                <br>
                <h4>What's wrong with it?</h4>
                <br>
                <div @keyup.enter="submitEntry">
                <ul>
                  <li class="input-group" v-for="(problem, index) in problems" style="padding:5px 10px;">
                  {{problem}}
                  <input type="checkbox" class="form-check" v-model="problemsEntry[index]">
                  </li>
                </ul>
              </div>
              <div class="input-group">
                <span class="input-group-btn">
                  <button @click="submitEntry" class="btn btn-default"
                    type="button">Check answer!</button>
                </span>
              </div>
            </div>

              <br>

            <svg width="200" height="200">
              <lewis-atom :stats='stats'></lewis-atom>
            </svg>


            <br>
            <div v-show="feedback" class="alert" v-bind:class="feedbackType"><p>{{feedback}}</p></div>
    </div>
</div>
</template>

<style>
</style>
<script>
import { mapGetters, mapActions } from 'vuex'
import _ from 'lodash'

export default {
  data: function() {
    return {
      entry: '',
      tries: 0,
      attempts: 0, //number of structures seen
      successes: 0,
      acc: 0,
      rts: [],
      startTime: 0,
      index: 0,
      followup: false,
      problems: ["missing lone pairs on the central atom", "missing lone pairs on peripheral atoms",
          "multiple bond to hydrogen", "second period atom with more than octet",
        "unnecessary radicals", "missing formal charges", "wrong formal charges",
        "atoms without octet (that should have octet)", "wrong number of electrons in structure",
        "bond split into radicals", "like formal charges on neighbors", "positive formal charge on fluorine"],
      problemsEntry: [0,0,0,0,0,0,0,0,0,0,0,0]
    }
  },
  //props: ['questionTypeID'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
      questionSetTime: 'getQuestionSetTime',
      stageData: 'getStageData',
      feedback: 'getFeedback',
      feedbackType: 'getFeedbackType',
      lewisHomo: 'getLewisHomoDiatomics',
      lewisHetero: 'getLewisHeteroDiatomics',
      lewisMulti: 'getLewisSimpleCentral',
      lewisTriCentral: 'getLewisTriatomicCentral',
      lewisIons: 'getLewisIons',
      elements: 'getLSE',
      lewisSessionData: 'getLewisSessionData'
    }),
    formulasArray: function() {
      //let temp = this.lewisHomo.concat(this.lewisHetero, this.lewisMulti)
      let temp = this.lewisHomo.concat(this.lewisHetero, this.lewisMulti, this.lewisTriCentral, this.lewisIons)
      return temp
    },
    formula: function() {
      return this.formulasArray[this.index]
    },
    question: function() {
      let maxErrors = 1
      if (this.attempts > 15 && this.successes/this.attempts > 0.85) maxErrors = 3
      else if (this.attempts > 10 && this.successes/this.attempts > 0.75) maxErrors = 3
      else if (this.attempts > 5 && this.successes > 3) maxErrors = 2
      let maxBonds = _.random() > 0
      return Vue.generalLewisStructure(this.formula, this.elements, maxBonds, this.lewisSessionData, maxErrors)
    },
    stats: function() {
      let directions = Array(12);
      directions.fill(0);
      let drawnAtoms = Array(this.question.structure.length);
      drawnAtoms.fill(0);
      return {
        center: [100,100],
        directions: directions,
        atomsArray: this.question.structure,
        drawnAtoms: drawnAtoms,
        index: 0,
      }
    }
  },
  created () {
    //this.index = _.random(0, this.formulasArray.length -1)
  },
  mounted () {

  },
  methods: {

    submitEntry: function(event) {
        this.tries += 1;
        let answerDetail = this.checkEntry();
        if (this.startTime === 0) {this.startTime = this.questionSetTime}
    	  answerDetail.timeStamp = Date.now();

        this.rts.push(answerDetail.timeStamp - this.questionSetTime);

      //console.log('rts is set to ', this.rts)
      this.startTime = Date.now();

    	let correct = answerDetail.correct;
    	let moveOn = false;
      let gotIt = false;

    	if (correct === 'correct') {

    		if (this.question.answer === 'y' || this.followup) {
          moveOn = true;
        }
        else this.followup = true
        if (this.tries === 1) {
          gotIt = true;
          this.successes++
        }
        this.acc = this.tries-1;
        this.$store.dispatch('setFeedbackType', {"alert-success": true});

        //console.log('acc is set to ', this.acc)
    	}

    	else {
        if (answerDetail.correct === 'formatError' || answerDetail.correct === 'noAnswer') {
          answerDetail.messageSent += " Try again!"}
        else if (this.question.answer === 'y' && answerDetail.correct === 'knownWrong') {
          answerDetail.messageSent += " Take another look, convince yourself it's good, and enter the correct answer. "
        }
        else if (this.question.answer === 'n' && answerDetail.correct === 'knownWrong' && !(this.followup)) {
          this.followup = true
        }
        else answerDetail.messageSent += " Take another look, and hit enter when you're satisfied."
    	}
      if (this.acc === 1) this.acc = 4;
      if (answerDetail.correct === 'formatError' || answerDetail.correct === 'dontKnow' || (moveOn === true && gotIt === false)) {
        this.$store.dispatch('setFeedbackType', {"alert-warning": true});
      }
      else if (gotIt === false) this.$store.dispatch('setFeedbackType', {"alert-danger": true});
      this.$store.dispatch('setFeedback', answerDetail.messageSent);
      let action = {};
      action.state_id = this.currentQuestion[4];
      action.type = 'answer given-' + correct;
      action.detail = answerDetail;
      action.time = answerDetail.timeStamp;

      //this code gives a 500 error now, should check laravel side
      //console.log("action is ", action);
      axios.post('../api/student/actions', action)
      .catch(function (error) {
        console.log(error);
      });

    	if (moveOn) {
    		//update states

        let updatedState = {rts: this.rts, accs: this.acc};
        //console.log("updatedState is", updatedState)
        this.$store.dispatch('updateRtsAccs', updatedState);
        updatedState = Vue.skillPriorityHelper(this.stageData);
        this.$store.dispatch('updateStage', updatedState);

        //set new question
        //console.log('about to set new question');
        this.$store.dispatch('setQuestion');
        this.$store.dispatch('setQuestionStart');

        //update props
        this.entry = ''
        this.tries = 0
        this.acc = 0
        this.rts = []
        this.attempts++
        this.index = _.random(0, this.formulasArray.length -1)
        //this.index = 20

    	}
    },

    //checks the entry, returns answerDetail
    checkEntry: function() {
      let answerDetailToReturn = {answer: this.entry, messageSent: '', correct: ''};
      if (this.followup) {
        answerDetailToReturn.answer = this.problemsEntry
        let missingProblems = []
        let extraProblems = []
        let numCorrect = 0
        for (let i = 0; i < 12; i++) {
          if (this.question.errors[i] !== this.problemsEntry[i]) {
            if (this.problemsEntry[i] === 1) extraProblems.push(i)
            else missingProblems.push(i)
          }
          else numCorrect++
        }
       if (missingProblems.length > 0) {
         answerDetailToReturn.messageSent += "The structure had these issues that you didn't select: "
         for (let i = 0; i < missingProblems.length; i++) {
           answerDetailToReturn.messageSent += this.problems[missingProblems[i]] + ", "
         }
       }
       if (extraProblems.length > 0) {
         answerDetailToReturn.messageSent += "You selected the following as issues, but the algorithm though they weren't: "
         for (i = 0; i < extraProblems.length; i++) {
           answerDetailToReturn.messageSent += this.problems[extraProblems[i]] + ", "
         }
       }
       if (extraProblems.length === 0 && missingProblems.length === 0) answerDetailToReturn.correct = 'correct'
       else if (numCorrect > 0) answerDetailToReturn.correct = 'close'
       else answerDetailToReturn.correct = 'knownWrong'
      }
      else {
        let entryTemp = this.entry.toLowerCase();
        //console.log('this.entry: ', this.entry);
        //console.log('this.answer: ', this.answers);
        if (entryTemp === '') {
          answerDetailToReturn.correct = 'noAnswer';
          answerDetailToReturn.messageSent += 'Please enter an answer. ';
        }
        else {
          const yArray = ['y', 'yes', 't', 'true'];
          const nArray = ['n', 'no', 'f', 'false'];
          if (yArray.indexOf(entryTemp) > -1) {entryTemp = 'y';}
          else if (nArray.indexOf(entryTemp) > -1) {entryTemp = 'n';}
          else {
            answerDetailToReturn.correct = 'formatError';
            answerDetailToReturn.messageSent = 'Please check the format of your answer. ';
          }
          if (entryTemp === this.question.answer) {
            answerDetailToReturn.correct = 'correct';
            answerDetailToReturn.messageSent += 'Correct!';
          }
          else {
            answerDetailToReturn.correct = 'knownWrong';
            answerDetailToReturn.messageSent += ' Incorrect.';
          if (this.question.answer === 'y') answerDetailToReturn.messageSent = " This is a good structure."
          else answerDetailToReturn.messageSent = " This structure isn't good."
          }
        }
      }

      //console.log(entryTemp, answerDetailToReturn)
      return answerDetailToReturn;
    }
  }
}
</script>
