<template>
  <div class="panel panel-default">
      <div class="panel-heading">Elements Practice!</div>

        <div class="panel-body">
          <div>Instructions: If you don't have any guesses, enter zero to see the answer.
          Don't capitalize names, but use correct capitalization for symbols.</div>
          <br>
          <div v-if="requestSymbol">
            What is the symbol of {{fact.prop}}?</div>
          <div v-if="!(requestSymbol)">
            What is the name of {{fact.key}}?</div>
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
      //determines whether name or formula is given
      requestSymbol: true,
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
      stageData: 'getStageData',
      facts: 'getFacts',
      elements: 'getElements'
    }),
    fact: function () {
      return this.$store.getters.getFactById(this.currentQuestion[1]);
    },
    answer: function() {
      let temp;
      if (this.requestSymbol) {temp = this.fact.key;}
      else {temp = this.fact.prop;}
      return temp;
    },
  },
  created () {
    this.requestSymbol = Math.random() >= 0.5;
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
        this.feedbackType = {"alert-success": true}

        //console.log('acc is set to ', this.acc)
    	}
    	else if (correct === 'dontKnow') {
    		moveOn = true;
    	}

    	else {
        if (this.tries === 1) {answerDetail.messageSent += " Try again!"}
        else if (this.tries === 2) {answerDetail.messageSent += " One more try!"}
        else moveOn = true;
    	}
      if (moveOn === true && gotIt === false) {
        if (this.requestSymbol) {
          answerDetail.messageSent = `The symbol of "${this.fact.key}" is
          "${this.answer}". We\'ll come back to it.`;
          this.acc = 4;
        }
        else {
          answerDetail.messageSent = `${this.fact.prop} is
          the symbol for ${this.answer}. We\'ll come back to it.`;
          this.acc = 4;
        }
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
        this.requestSymbol = Math.random() >= 0.5;
    	}
    },

    //checks the entry, returns answerDetail
    checkEntry: function() {
      let answerDetailToReturn = {messageSent: '', correct: ''};
      //console.log('this.entry: ', this.entry);
      //console.log('this.answer: ', this.answers);
      if (this.entry === '') {
            answerDetailToReturn.correct = 'noAnswer';
            answerDetailToReturn.messageSent += 'If you don\'t know the answer, enter zero. ';
          }
          else if (Number(this.entry) === 0) {
            answerDetailToReturn.correct = 'dontKnow';
          }
          else if (this.entry === this.answer) {
            answerDetailToReturn.correct = 'correct';
          }
          else if (this.entry.toLowerCase() === this.answer.toLowerCase()) {
            answerDetailToReturn.correct = 'formatError';
            answerDetailToReturn.messageSent += 'Almost there, please check your capitalization. ';
          }
          else {
            for (let fact of this.facts) {
              //console.log(this.facts, fact)
              //console.log(this.entry, fact.key);
              if (this.requestSymbol) {
                if (this.entry === fact.key) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent = `${this.entry} is ${fact.prop}.`;
                  break;
                }
              }
              else {
                if (this.entry === fact.prop) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent = `The symbol for ${this.entry} is  ${fact.key}.`;
                  break;
                }
              }
            }
          }
          if (answerDetailToReturn.correct === '') {
            answerDetailToReturn.correct = 'unknownWrong';
            if (!this.requestFormula) {
              answerDetailToReturn.messageSent = 'Spell carefully! ';}
          }
          return answerDetailToReturn;
        },
    }
  }
</script>
