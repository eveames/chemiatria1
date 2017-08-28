<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Significant Figures Practice!</div>

                  <div class="panel-body">
                    Instructions: Enter the number of significant figures (digits)
                      in the number displayed.
                    <br>
                    <div >
                      <h4>{{word.prompts[0]}}</h4>
                      <br>
                      <div class="input-group">
                        <input autofocus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control">
                        <span class="input-group-btn">
                          <button @click="submitEntry" class="btn btn-default"
                            type="button">Submit answer!</button>
                        </span>
                      </div>
                      <br>
                      <div v-show="feedback" class="alert" v-bind:class="feedbackType"><p>{{feedback}}</p></div>
                  </div>
              </div>
          </div>
      </div>
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
      feedback: '',
      acc: 0,
      rts: [],
      startTime: 0,
      zeroString: '000000000000',
      feedbackType: {
        "alert-success": true,
      }
    }
  },
  //props: ['questionTypeID'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
      questionSetTime: 'getQuestionSetTime',
      stageData: 'getStageData'
    }),
    question: function() {
      let setTime = questionSetTime;
      let number = String(_.random(1,9));
      let answer = 0;
      let hint = '';
      if (currentQuestion.skill === 'SigFigs: no decimal place') {
        let middleDigits = Vue.randomDigitString(_.random(0,2), 3);
        number += String(middleDigits);
        number += String(_.random(1,9));
        answer = number.length;
        let numZeros = _.random(0,2);
        let zeros = zeroString.slice(0, numZeros);
        number += String(zeros);
        hint = ['only count zeros in between non-zero digits'];
        //only show this if wrong
        message = 'If there is no decimal point, every non-zero digit and every zero between non-zero digits is significant';
      }
      else if (currentQuestion.skill === 'SigFigs: decimal places') {
        let firstDigits = Vue.randomDigitString(_random(1,2), 3);
        number += String(firstDigits);
        number += '.';
        let afterDigits = Vue.randomDigitString(_random(1,2), 3);
        number += String(afterDigits);
        answer = firstDigits.length + 1 + afterDigits.length;
        hint = ['Zeros at the end count if there\'s a decimal point'];
        message = 'Zeros at the end count if there\'s a decimal point';
      }
      else if (currentQuestion.skill === 'SigFigs: decimal only') {
        let numZerosBefore = _.random(0,3);
        let zerosBefore = zeroString.slice(0, numZerosBefore);
        let middleDigits = number + String(Vue.getRandomString(_.random(0,2), 3));
        let numZerosAfter = _.random(0,2);
        let zerosAfter = zeroString.slice(0, numZerosAfter);
        number = '0.' + String(zerosBefore) + String(middleDigits) + String(zerosAfter);
        answer = middleDigits.length + zerosAfter.length;
        hint = ['Zeros at the end count if there\'s a decimal point'];
        message = 'Zeros at the end count if there\'s a decimal point';
      }
      else if (currentQuestion.skill === 'SigFigs: ends in decimal point') {
        let middleDigits = Vue.randomDigitString(_.random(0,2), 3);
        number += String(middleDigits);
        number += String(_.random(1,9));
        let numZeros = _.random(1,2);
        let zeros = zeroString.slice(0, numZeros);
        number += zeros;
        answer = number.length;
        number += '.';
        hint = ['If there\'s a decimal point but nothing after it, all the digits are significant.'];
        message = 'If there\'s a decimal point but nothing after it, all the digits are significant.';
      }
      return {number: number, answer: answer, hint: hint, message: message, setTime: setTime}
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
      console.log('rts is set to ', this.rts)
      this.startTime = Date.now();

    	let correct = answerDetail.correct;
    	let moveOn = false;
      let gotIt = false;

    	if (correct === 'correct') {
    		answerDetail.messageSent += ' Correct!';
    		moveOn = true;
        gotIt = true;
        this.acc = this.tries-1;
        this.feedbackType = {"alert-success": true}
        //console.log('acc is set to ', this.acc)
    	}
    	else {
        if (this.tries < 3) {answerDetail.messageSent += "Try again!"}
        else moveOn = true;
    	}
      if (moveOn === true && gotIt === false) {
        answerDetail.messageSent = this.question.message;
        this.acc = 4;
      }
      if (answerDetail.correct === 'formatError') {
        this.feedbackType = {"alert-warning": true}
      }
      else if (gotIt === false) this.feedbackType = {"alert-danger": true}
      this.feedback = answerDetail.messageSent;
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
        console.log("updatedState is", updatedState)
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
    	}
    },

    //checks the entry, returns answerDetail
    checkEntry: function() {
      let answerDetailToReturn = {answer: this.entry, correct: '', messageSent: ''};
      //console.log('this.entry: ', this.entry);
      //console.log('this.answer: ', this.answers);
      if (this.entry === '') {
            answerDetailToReturn.correct = 'noAnswer';
            answerDetailToReturn.messageSent += 'Please enter a number. ';
          }
      else if (Number(this.entry) === Number(this.question.answer)) {
        answerDetailToReturn.correct = 'correct';
      }
      else {
        if (isNaN(Number(this.entry))) {
          answerDetailToReturn.correct = 'formatError';
          answerDetailToReturn.messageSent = 'Answer should be a number. ';
        }
        else if (Number(this.entry) % 1 !== 0) {
          answerDetailToReturn.correct = 'formatError';
          answerDetailToReturn.messageSent = 'Answer should be an integer. ';
        }
        else {
          answerDetailToReturn.correct = 'knownWrong';
        }
      }
      return answerDetailToReturn;
    },
  }
}
</script>
