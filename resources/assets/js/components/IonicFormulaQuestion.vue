<template>
  <div class="panel panel-default">
      <div class="panel-heading">Ionic Compounds Practice!</div>

        <div class="panel-body">
          <div>Instructions: If you don't have any guesses, enter zero to see the answer.
          If you are asked for a formula, all numbers will be converted to subscripts, so write '(NH4)3C6H5O7' for
          <span v-html="this.$options.filters.formatFormula('(NH4)3C6H5O7')"></span>. Recall that compounds are always charge balanced.<br>
          Note that these questions are generated randomly from a list of common ions, and may not all be actual stable compounds.
          </div>
          <br>
          <div v-if="requestFormula">
            What is the formula of {{question.name}}?

            Your answer is: <span v-html="this.$options.filters.formatFormula(entry)"></span></div>
          <div v-if="!(requestFormula)">
            What is the name of <span v-html="this.$options.filters.formatFormula(question.formula)"></span>?</div>
            <br>
          <div class="input-group">
              <input v-focus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control" autocapitalize="off" autocorrect="off">
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
      acc: 0,
      rts: [],
      startTime: 0,
      //determines whether name or formula is given
      requestFormula: true,
      romanNums: ['','I','II','III','IV','V','VI','VII', 'VIII'],

    }
  },
  //props: ['questionTypeID'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
      questionSetTime: 'getQuestionSetTime',
      stageData: 'getStageData',
      facts: 'getFacts',
      ions: 'getIons',
      feedback: 'getFeedback',
      feedbackType: 'getFeedbackType'
    }),

    question: function() {
      let setTime = this.questionSetTime;
      let anions = this.ions.an;
      let cations = this.ions.cat;
      if (this.currentQuestion[6] === 'complex ionic formulas') {
        anions = anions.concat(this.ions.polyan);
        cations = cations.concat(this.ions.polycat);
      }
      let anion = anions[_.random(0, anions.length-1)];
      let cation = cations[_.random(0, cations.length-1)];
      let question = Vue.ionicNameFormula(cation, anion);
      question.setTime = setTime;
      return question;
    },
  },
  created () {
    this.requestFormula = Math.random() >= 0.5;
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
        if (this.tries < 3) {answerDetail.messageSent += " Try again!"}
        else moveOn = true;
    	}
      if (moveOn === true && gotIt === false) {
        if (this.requestFormula) {
          answerDetail.messageSent = `The formula of "${this.question.name}" is
          "${this.question.formula}". We\'ll come back to it.`;
          this.acc = 4;
        }
        else {
          answerDetail.messageSent = `The name of "${this.question.formula}" is
          "${this.question.name}". We\'ll come back to it.`;
          this.acc = 4;
        }
      }
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
        this.requestFormula = Math.random() >= 0.5;
    	}
    },

    //checks the entry, returns answerDetail
    checkEntry: function() {
      let answerDetailToReturn = {answer: this.entry, messageSent: '', correct: ''};
      //console.log('this.entry: ', this.entry);
      //console.log('this.answer: ', this.answers);
      if (this.entry === '') {
            answerDetailToReturn.correct = 'noAnswer';
            answerDetailToReturn.messageSent += 'If you don\'t know the answer, enter zero. ';
      }
      else if (Number(this.entry) === 0) {
            answerDetailToReturn.correct = 'dontKnow';
      }
          //if answer is formula:
      if (this.requestFormula) {
            if (this.entry === this.question.formula) {
              answerDetailToReturn.correct = 'correct';
            }
            else if (this.entry.toLowerCase() === this.question.formula.toLowerCase()){
              answerDetailToReturn.correct = 'close';
              answerDetailToReturn.messageSent = 'Check your capitalization!';
            }
            //later, try to parse answer and give specific feedback
            //break into cation and anion
            //check quantity of ions and correct identity
            //check parentheses
            else {
              const reCatParen = /\(([A-Z][a-z]*)\)(\d?)([A-Z][a-z]*)(\d?)/;
              const reAnParen = /([A-Z][a-z]*)(\d?)\(([A-Z][a-z]*)\)(\d?)/;
              const reBothParen = /\(([A-Z][a-z]*)\)(\d?)\(([A-Z][a-z]*)\)(\d?)/;
              const reNoParen = /([A-Z][a-z]*)(\d?)([A-Z][a-z]*)(\d?)/;
              let parensE = 0;
              let reArrayE = reCatParen.exec(this.entry);
              if (!reArrayE) {
                reArrayE = reAnParen.exec(this.entry);
                parensE = 1;
              }
              if (!reArrayE) {
                reArrayE = reBothParen.exec(this.entry);
                parensE = 2;
              }
              if (!reArrayE) {
                reArrayE = reNoParen.exec(this.entry);
                parensE = 3;
              }
              if (!reArrayE) {
                answerDetailToReturn.correct = 'unknownWrong';
                answerDetailToReturn.messageSent = 'Make sure your answer is formatted like an ionic formula.';
              }
              else {
                let parensA = 0;
                let reArrayA = reCatParen.exec(this.question.formula);
                if (!reArrayA) {
                  reArrayA = reAnParen.exec(this.question.formula);
                  parensA = 1;
                }
                if (!reArrayA) {
                  reArrayA = reBothParen.exec(this.question.formula);
                  parensA = 2;
                }
                if (!reArrayA) {
                  reArrayA = reNoParen.exec(this.question.formula);
                  parensA = 3;
                }
                if (parensA !== parensE) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your parentheses. ';
                }
                if (reArrayA[1] !== reArrayE[1]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your cation. ';
                }
                if (reArrayA[3] !== reArrayE[3]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your anion. ';
                }
                if (reArrayA[2] !== reArrayE[2] || reArrayA[4] !== reArrayE[4]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check the number of ions. ';
                }
              }
            }
          }

          //if answer is name:
          else {
            if (this.entry === this.question.name) {
              answerDetailToReturn.correct = 'correct';
            }
            else if (this.entry.toLowerCase() === this.question.name.toLowerCase()){
              answerDetailToReturn.correct = 'close';
              answerDetailToReturn.messageSent = 'Check your capitalization!';
            }
            else {
              const reName = /(\w+)(\([IVX]+\))?\s(\w+)/;
              let reArrayNA = reName.exec(this.question.name);
              let reArrayNE = reName.exec(this.entry);
              if (!reArrayNE) {
                answerDetailToReturn.correct = 'unknownWrong';
                answerDetailToReturn.messageSent = 'Check the format of your answer. ';
              }
              else{
                if (reArrayNE[1] !== reArrayNA[1] || reArrayNE[2] !== reArrayNA[2]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your cation. ';
                }
                if (reArrayNE[3] !== reArrayNA[3]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your anion. ';
                }
              }
            }
          }
          return answerDetailToReturn;
        },
    }
  }
</script>
