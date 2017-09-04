<template>
  <div class="panel panel-default">
      <div class="panel-heading">Elements Practice!</div>

        <div class="panel-body">
          <div v-if="tableFormat">
            <div>Instructions: Either click inside the correct box, or enter the correct box's label
              (not case-sensitive). Then hit return/enter. If you don't know the answer,
              you can enter 0. The correct answer will be displayed and you'll see it again soon.</div>
          <br>
          <h4>Select the location of <strong>{{nameOrSymbol}}</strong> in the periodic table:</h4>
            <br>
            <div>
            <table class="table-cell-bordered" v-model="entry" @keyup.enter="submitEntry"><tbody>
              <col span="18"/>
                <tr><td @click="entry = '1';submitEntry()">1</td>
                  <td colspan="16" class="no-border"></td>
                  <td @click="entry = '2';submitEntry()">2</td></tr>
                <tr><td @click="entry = '3';submitEntry()">3</td>
                  <td @click="entry = '4';submitEntry()">4</td>
                  <td colspan="10" rowspan="2" class="no-border"></td>
                  <td @click="entry = '5';submitEntry()">5</td>
                  <td @click="entry = '6';submitEntry()">6</td>
                  <td @click="entry = '7';submitEntry()">7</td>
                  <td @click="entry = '8';submitEntry()">8</td>
                  <td @click="entry = '9';submitEntry()">9</td>
                  <td rowspan="5" @click="entry = 'NG';submitEntry()">NG</td></tr>
                <tr><td @click="entry = '11';submitEntry()">11</td>
                  <td @click="entry = '12';submitEntry()">12</td>
                  <td @click="entry = '13';submitEntry()">13</td>
                  <td @click="entry = '14';submitEntry()">14</td>
                  <td @click="entry = '15';submitEntry()">15</td>
                  <td @click="entry = '16';submitEntry()">16</td>
                  <td @click="entry = '17';submitEntry()">17</td></tr>
                <tr><td @click="entry = '19';submitEntry()">19</td>
                  <td @click="entry = '20';submitEntry()">20</td>
                  <td colspan="3" rowspan="3" @click="entry = 'ETM';submitEntry()">ETM</td>
                  <td colspan="3" rowspan="3" @click="entry = 'MTM';submitEntry()">MTM</td>
                  <td colspan="2" rowspan="3" @click="entry = 'LTM';submitEntry()">LTM</td>
                  <td rowspan="3" @click="entry = 'CM';submitEntry()">CM</td>
                  <td colspan="3" rowspan="3" @click="entry = 'PTM';submitEntry()">PTM</td>
                  <td colspan="2" rowspan="3" @click="entry = 'NM';submitEntry()">NM</td>
                  <td rowspan="3" @click="entry = 'Hal';submitEntry()">Hal</td></tr>
                <tr><td rowspan="2" @click="entry = 'AM';submitEntry()">AM</td>
                  <td rowspan="2" @click="entry = 'AEM';submitEntry()">AEM</td></tr>
                <tr></tr>
              </tbody></table>
            </div>
          </div>
          <div v-if="!(tableFormat)">
            <div>Instructions: Enter the number of your answer, or click on the answer and hit enter.
              Don't type in the word! Make sure you choose the most specific description.</div>
              <br>
              <h4>Choose the most specific correct classification for <strong>{{nameOrSymbol}}</strong>:</h4>
              <br>
              <div @keyup.enter="submitEntry">
              <p class="input-group" v-for="(group, index) in families" @click="entry=index; submitEntry()"
                style="padding:5px 10px;">
                {{index}}. {{group}}
              </p>
            </div>
          </div>
            <br>
            <div class="input-group">
              <input v-focus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control">
              <span class="input-group-btn">
                <button @click="submitEntry" class="btn btn-default"
                  type="button">Submit answer!</button>
              </span>
            </div>
            <div v-show="feedback" class="alert" v-bind:class="feedbackType"><p>{{feedback}}</p></div>
    </div>
</div>
</template>

<style>
.table-cell-bordered {
  border: none;
  width: 100%;
  margin-bottom: 20px;
  border-collapse: separate;
  border-spacing: 10px;
}
.table-cell-bordered > tbody > col {
    min-width: 5.5%; /* 100%/18 cols */
  }
 .table-cell-bordered > tbody > tr >td {
  border: solid 2px;
  border-color: black;
  padding: 5px;
}
.table-cell-bordered > tbody > tr {
  height: 1em;
}
 .table-cell-bordered > tbody > tr >td.no-border {
  border: none;
}
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
      tableFormat: false,
      useSymbol: true,
      families: ['halogen', 'chalcogen', 'alkali metal', 'alkaline earth metal',
        'noble gas', 'post-transition metal', 'coinage metal', 'transition metal', 'non-metal', 'metal']
    }
  },
  //props: ['questionTypeID'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
      questionSetTime: 'getQuestionSetTime',
      stageData: 'getStageData',
      facts: 'getFacts',
      feedback: 'getFeedback',
      feedbackType: 'getFeedbackType'
    }),
    fact: function () {
      return this.$store.getters.getFactById(this.currentQuestion[1]);
    },
    element: function() {
      //console.log(Number(this.fact.key_name)-1)
      return this.$store.getters.getElementByIndex(Number(this.fact.key_name) - 1);
    },
    answers: function() {
      let temp = [];
      if (this.tableFormat)temp = [{alt: this.element.location, correct: 'correct', message: ''}]
      else {
        temp = [{alt: this.element.findex, correct: 'correct', message: ''}];
        if (this.element.findex === 57) {
          temp[0].alt = 5;
          temp[0].message = 'Zn, Cd and Hg are considered either transition or post-transition metals. ';
          temp.push({alt: 7, correct: 'correct',
          message: 'Zn, Cd and Hg are considered either transition or post-transition metals. '});
        }
        if (this.element.findex === 0 || this.element.findex === 1 || this.element.findex === 4) {
          temp.push({alt: 8, correct: 'close', message: 'It is a non-metal, but be more specific!'});
        }
        else if (this.element.findex === 2 || this.element.findex === 3 || this.element.findex === 5
          || this.element.findex === 6 || this.element.findex === 7) {
          temp.push({alt: 9, correct: 'close', message: 'It is a metal, but be more specific!'});
          if (this.element.findex === 6) {
            temp.push({alt: 7, correct: 'close', message: 'It is a transition metal, but be more specific!'});
          }
        }
      }
      return temp;
    },
    nameOrSymbol: function() {
      if (this.useSymbol) return this.fact.key;
      else return this.fact.prop;
    }
  },
  created () {
    this.tableFormat = Math.random() >= 0.5;
    this.useSymbol = Math.random() >= 0.5;
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
        else if (this.tries === 2) {answerDetail.messageSent += " One more try!"}
        else moveOn = true;
    	}
      if (moveOn === true && gotIt === false) {
        if (this.tableFormat) {
          answerDetail.messageSent = `${this.fact.key} is
          in ${this.answers[0].alt}. We\'ll come back to it.`;
          this.acc = 4;
        }
        else {
          answerDetail.messageSent = `${this.fact.prop} is
          the symbol for ${this.answer}. We\'ll come back to it.`;
          this.acc = 4;
        }
      }
      if ( answerDetail.correct === 'close'
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
        this.useSymbol = Math.random() >= 0.5;
        this.tableFormat = Math.random() >= 0.5;
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
      else if (this.tableFormat && Number(this.entry) === 0) {
        answerDetailToReturn.correct = 'dontKnow';
      }
      for(let i = 0; i < this.answers.length; i++) {
        if (this.tableFormat && this.entry.toLowerCase() === this.answers[i].alt.toLowerCase()) {
          answerDetailToReturn.correct = this.answers[i].correct;
          answerDetailToReturn.messageSent += this.answers[i].message;
          break;
        }
        else if (!(this.tableFormat) && Number(this.entry) === Number(this.answers[i].alt)) {
          answerDetailToReturn.correct = this.answers[i].correct;
          answerDetailToReturn.messageSent += this.answers[i].message;
          break;
        }
      }
      if (answerDetailToReturn.correct === '') {
        answerDetailToReturn.correct = 'unknownWrong';
      }
      return answerDetailToReturn;
    },
  }
}
</script>
