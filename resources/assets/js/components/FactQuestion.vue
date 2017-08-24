<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <polyatomic-ion-question v-if="fact.group_name === 'polyatomic ions' ||
            fact.group_name === 'acids' "></polyatomic-ion-question>
          <element-symbol-question v-if="fact.group_name === 'elementSymbol'"></element-symbol-question>
          <element-charge-question v-if="fact.group_name === 'elementCharge'"></element-charge-question>
          <element-group-question v-if="fact.group_name === 'elementGroup'"></element-group-question>
      </div>
  </div>
</div>
</template>


<style>
</style>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data: function() {
    return {
      entry: '',
      tries: 0,
      feedback: '',
      acc: 0,
      rts: [],
      startTime: 0,
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
    fact: function () {
      return this.$store.getters.getFactById(this.currentQuestion[1]);
    },
    answers: function() {
      let temp = [{alt: this.word.word, correct: 'correct'}];
      temp = temp.concat(this.word.altwords);
      return temp;
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
    	else if (correct === 'dontKnow') {
    		moveOn = true;
    	}

    	else {
        if (this.tries < 3) {answerDetail.messageSent += "Try again!"}
        else moveOn = true;
    	}
      if (moveOn === true && gotIt === false) {
        answerDetail.messageSent = `Answer to "${this.word.prompts[0]}" is
        "${this.answers[0].alt}". We\'ll come back to it.`;
        this.acc = 4;
      }
      if (answerDetail.correct === 'formatError' || answerDetail.correct === 'close'
        || answerDetail.correct === 'dontKnow') {
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
    	}
    },

    //checks the entry, returns answerDetail
    checkEntry: function() {
      let answerDetailToReturn = {messageSent: ''};
      //console.log('this.entry: ', this.entry);
      //console.log('this.answer: ', this.answers);
      if (this.entry === '') {
            answerDetailToReturn.correct = 'noAnswer';
            answerDetailToReturn.messageSent += 'If you don\'t know the answer to a vocab question, enter zero. ';
          }
          else if (Number(this.entry) === 0) {
            answerDetailToReturn.correct = 'dontKnow';
          }
          else {
            for (var i = 0; i < this.answers.length ; i++){
              if (this.entry === this.answers[i].alt) {
                answerDetailToReturn.correct = this.answers[i].correct;
                if (this.answers[i].message) {answerDetailToReturn.messageSent += this.answers[i].message + ' ';}
                break;
              }
              else if (this.entry.toLowerCase() === this.answers[i].alt.toLowerCase()) {
                if (this.answers[i].correct === 'correct') {
                  answerDetailToReturn.correct = 'formatError';
                  answerDetailToReturn.messageSent += 'Almost there, please check your capitalization. ';
                  break;
                }
              }
            }
            if (!answerDetailToReturn.correct) {
              answerDetailToReturn.correct = 'unknownWrong';
              answerDetailToReturn.messageSent += 'I don\'t recognize your answer. Spell carefully! ';
            }
          }
          return answerDetailToReturn;
        },
    }
  }
</script>
