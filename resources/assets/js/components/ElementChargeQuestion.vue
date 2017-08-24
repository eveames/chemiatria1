<template>
  <div class="panel panel-default">
      <div class="panel-heading">Elements Practice!</div>

        <div class="panel-body">
          <div v-if="chargeGiven">
            Instructions: Enter y or n. By reasonable charge, I mean one of the two most common charges
                when the given element forms single-atom ions under normal circumstances. If the element
                does not form single-atom ions normally, then answer n.
            <br><br>
            Is {{charge | chargeFormat}} a reasonable charge for {{nameOrSymbol}}?</div>
          <div v-if="!(chargeGiven)">
            Instructions: Enter a number (with sign). By reasonable charge, I mean one of the two most common charges
                when the given element forms single-atom ions under normal circumstances. If the element
                does not form single-atom ions normally, then answer 0.
            <br><br>
            Enter a reasonable charge for {{nameOrSymbol}}:</div>
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
      //determines whether name or formula is given
      chargeGiven: true,
      charge: 0,
      useSymbol: true,
      chargesArray: [-3, -2, -1, 1, 2, 3, 4, 5],
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
    element: function() {
      console.log(Number(this.fact.key_name)-1)
      return this.$store.getters.getElementByIndex(Number(this.fact.key_name) - 1);
    },
    charges: function() {
      return this.$store.getters.getElementChargesByIndex(Number(this.fact.key_name) -1);
    },
    answers: function() {
      let temp;
      if (this.chargeGiven) {
        temp = this.setupAnswersYN();
      }
      else {
        temp = this.setupAnswersCharge();
      }
      return temp;
    },
    nameOrSymbol: function() {
      if (this.useSymbol) return this.fact.key;
      else return this.fact.prop;
    }
  },
  created () {
    this.chargeGiven = Math.random() >= 0.5;
    this.useSymbol = Math.random() >= 0.5;
    if (this.chargeGiven) this.charge = this.chargesArray[_.random(0, 7)];
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
        else if (answerDetail.correct === 'formatError' || answerDetail.correct === 'noAnswer') {
          answerDetail.messageSent += " Try again!"}
        else moveOn = true;
    	}
      if (moveOn === true && gotIt === false) this.acc = 4;
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
      else if (this.chargeGiven){
        const yArray = ['y', 'yes', 't', 'true'];
        const nArray = ['n', 'no', 'f', 'false'];
        if (yArray.indexOf(entryTemp) > -1) {entryTemp = 'y';}
        else if (nArray.indexOf(entryTemp) > -1) {entryTemp = 'n';}
        else {
          answerDetailToReturn.correct = 'formatError';
          answerDetailToReturn.messageSent = 'Please check the format of your answer. ';
        }
      }
      else {
        const regex = /(\d+)([+-])/;
        entryTemp = entryTemp.replace(regex, '$2$1');
        entryTemp = Number(entryTemp);
        if (isNaN(entryTemp)) {
          answerDetailToReturn.correct = 'formatError';
          answerDetailToReturn.messageSent = 'Please check the format of your answer. ';
        }
      }
      console.log(entryTemp, answerDetailToReturn)

      if (answerDetailToReturn.correct === "") {
        console.log('inside if')
        for (let i = 0; i < this.answers.length; i++) {
          console.log(this.answers[i], this.answers[i].alt.indexOf(entryTemp))
          if (this.answers[i].alt.indexOf(entryTemp) !== -1) {
            answerDetailToReturn.correct = this.answers[i].correct;
            answerDetailToReturn.messageSent = this.answers[i].message;
            break;
          }
        }
      }
      return answerDetailToReturn;
    },
    setupAnswersYN: function() {
      let answerTemp = [{alt: '', correct: '', message: ''}];
      // y is correct
      console.log(this.charge, this.element.charge)
      let correct = false;
      if (this.element.charge === this.charge) correct = true;
      else if (Array.isArray(this.element.charge) && this.element.charge.indexOf(this.charge) > -1)  {
        correct = true;
      }
      if (correct) {
        for (let i = 0; i < this.charges.length ; i++) {
          if(this.charges[i].alt === this.charge && this.charges[i].op === 'equals') {
            answerTemp.push({alt: 'y', correct: 'correct', message: this.charges[i].message})
          }
        }
        answerTemp.push({alt: 'n', correct: 'knownWrong', message: answerTemp[0].message})
      }
      //n is correct
      else {
        //console.log(this.charges)
        for (let i = 0; i < this.charges.length; i++) {
          //console.log(i)
          //console.log(this.charges[i])
          //check for equals, greater or less match to this.charge
          if(this.charges[i].alt === this.charge && this.charges[i].op === 'equals') {
            //console.log("one", this.charges[i])
            answerTemp.push({alt:'y', correct: this.charges[i].correct, message: this.charges[i].message})
          }
          else if (this.charge > this.charges[i].alt && this.charges[i].op === 'greater') {
            //console.log("two", this.charges[i])
            answerTemp.push({alt:'y', correct: this.charges[i].correct, message: this.charges[i].message})
          }
          else if (this.charge < this.charges[i].alt && this.charges[i].op === 'less') {
            //console.log("three", this.charges[i])
            answerTemp.push({alt:'y', correct: this.charges[i].correct, message: this.charges[i].message})
          }
          else if (this.charge != this.charges[i].alt && this.charges[i].op === 'notEqual') {
            //console.log("four", this.charges[i])
            answerTemp.push({alt:'y', correct: this.charges[i].correct, message: this.charges[i].message})
          }
          else if (this.charges[i].correct === 'correct' && answerTemp[0].correct !== 'correct') {
            //console.log("five", this.charges[i])
            answerTemp.unshift({alt:'n', correct: this.charges[i].correct, message: this.charges[i].message})
          }
        }
      }
      //console.log(answerTemp)
      return answerTemp;
    },
    setupAnswersCharge: function() {
      let answerTemp = [];
      let correctAlt = {alt: [], correct: 'correct', message: ''};
      let chargesTemp = [-3, -2, -1, 1, 2, 3, 4, 5];
      for (let i = 0; i < this.charges.length; i++) {
        if (this.charges[i].correct === 'correct') {
          correctAlt.alt.push(this.charges[i].alt);
          correctAlt.message += this.charges[i].message;
          let k = chargesTemp.indexOf(this.charges[i].alt)
          if (k !== -1) chargesTemp.splice(k, 1)
        }
        else if (this.charges[i].op === 'equals') {
          let k = chargesTemp.indexOf(this.charges[i].alt)
          if (k !== -1) chargesTemp.splice(k, 1)
          answerTemp.push({alt: [this.charges[i].alt], correct: this.charges[i].correct, message: this.charges[i].message})
        }
        else if (this.charges[i].op === 'greater') {
          let k = chargesTemp.indexOf(this.charges[i].alt)
          let n = chargesTemp.length - k
          let altTemp = chargesTemp.splice(k +1, n)
          answerTemp.push({alt: altTemp, correct: this.charges[i].correct, message: this.charges[i].message})
        }
        else if (this.charges[i].op === 'less') {
          let k = chargesTemp.indexOf(this.charges[i].alt)
          let altTemp = chargesTemp.splice(0, k)
          answerTemp.push({alt: altTemp, correct: this.charges[i].correct, message: this.charges[i].message})
        }
        else {
          answerTemp.push({alt: chargesTemp, correct: this.charges[i].correct, message: this.charges[i].message})
        }
      }
      answerTemp.unshift(correctAlt);
      return answerTemp;
    }
  }
}
</script>
