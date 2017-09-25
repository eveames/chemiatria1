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
      acc: 0,
      rts: [],
      startTime: 0,
      //determines whether name or formula is given
    }
  },
  //props: ['questionTypeID'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
      questionSetTime: 'getQuestionSetTime',
      stageData: 'getStageData',
      feedback: 'getFeedback',
      feedbackType: 'getFeedbackType'
    }),
    atomsArray: function() {
      return  [
          [0, 0, 'carbon', [[1,1],[2,1],[3,1],[4,1]], 0],
          [1, 0, 'hydrogen', [[0,1]], 0],
          [2, 0, 'hydrogen', [[0,1]], 0],
          [3, 0, 'hydrogen', [[0,1]], 0],
          [4, 0, 'hydrogen', [[0,1]], 0]
        ];
    },
    formula: function() {
      return 'CH4';
    },
    answer: function() {
      return 'y';
    },
    stats: function() {
      let directions = Array(12);
      directions.fill(0);
      let drawnAtoms = Array(this.atomsArray.length);
      drawnAtoms.fill(0);
      return {
        center: [100,100],
        directions: directions,
        atomsArray: this.atomsArray,
        drawnAtoms: drawnAtoms,
        index: 0
      }
    }
  },
  created () {

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
    		answerDetail.messageSent += ' Correct!';
    		moveOn = true;
        gotIt = true;
        this.acc = this.tries-1;
        this.$store.dispatch('setFeedbackType', {"alert-success": true});

        //console.log('acc is set to ', this.acc)
    	}
    	else if (correct === 'dontKnow') {
    		moveOn = true;
    	}

    	else {
        if (this.tries === 1) {answerDetail.messageSent += " Try again!"}
        else if (answerDetail.correct === 'formatError' || answerDetail.correct === 'noAnswer') {
          answerDetail.messageSent += " Try again!"}
        else moveOn = true;
    	}
      if (moveOn === true && gotIt === false) this.acc = 4;
      if (answerDetail.correct === 'formatError' || answerDetail.correct === 'close'
        || answerDetail.correct === 'dontKnow') {
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
        updatedState = Vue.factPriorityHelper(this.stageData);
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
        this.chargeGiven = Math.random() >= 0.5;
        this.useSymbol = Math.random() >= 0.5;
        if (this.chargeGiven) this.charge = this.chargesArray[_.random(0, 7)];
        else this.charge = 0;
    	}
    },

    //checks the entry, returns answerDetail
    checkEntry: function() {
      let answerDetailToReturn = {answer: this.entry, messageSent: '', correct: ''};
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
        if (entryTemp === this.answer) {
          answerDetailToReturn.correct = 'correct';
        }
        else answerDetailToReturn.correct = 'knownWrong';
      }

      //console.log(entryTemp, answerDetailToReturn)
      return answerDetailToReturn;
    },

  }
}
</script>
