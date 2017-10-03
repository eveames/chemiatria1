<template>
  <div class="panel panel-default">
      <div class="panel-heading">General Nomenclature Practice!</div>

        <div class="panel-body">
          <div>
            Instructions: If you are asked for a formula,
            use the following format: write 'VO2+1' for <span v-html="this.$options.filters.formatFormula('VO2+1')"></span>. Recall that compounds are always charge balanced.<br>
          Note that ionic compounds in this practice are generated randomly, and may not all actually exist. To the best of my
          knowledge, the covalent example compounds do exist but may be quite unstable.
          </div>
          <br>
          <h3 v-if="requestFormula">
            We need to convert {{question.name}} to a formula.</h3>
          <h3 v-if="!(requestFormula)">
            We need to convert <span v-html="this.$options.filters.formatFormula(question.formula)"></span> to a name.</h3>

          <div v-if='easymode'><h4>First, you need to decide if this is a compound or an ion.</h4>
            <button @click="neutralOrNot(0)" class="btn btn-default"
              type="button">Ion</button>
            <button @click="neutralOrNot(1)" class="btn btn-default"
              type="button">Compound</button>
          </div>

          <div v-if='easymode && stage > 0'>
            <h4 v-if='successes[0]'>{{stage1response}} Correct!</h4>
            <div v-if="!successes[0]">
              <h4>{{stage1response}}</h4><br>
              If given a formula, if a charge is not given, it is a neutral compound.
              If given a name, an ion name will be one word or will be "_____ ion", while an ionic or binary covalent
              compound name will have two words neither of which is "ion". (There are compounds with one word names, but
              we haven't learned about them yet. Organic compounds like methane and ethanol are examples; they won't end in
              '-ide', '-ate' or '-ite'.)</div>
            <br>
            <div v-if="type > 0"><h4>Next, we need to decide which type of nomenclature to use. If it could be acid or covalent, pick acid.</h4>
              <button @click="typeCheck(1)" class="btn btn-default"
                type="button">Ionic</button>
              <button @click="typeCheck(2)" class="btn btn-default"
                type="button">Covalent</button>
              <button @click="typeCheck(3)" class="btn btn-default"
                type="button">Acid</button>
            </div>
          </div>

          <div v-if="easymode && stage >1 && type > 0">
            <h4 v-if="successes[1]">{{stage2response}} Correct!</h4>
            <div v-if="!successes[1]"><h4>{{stage2response}}</h4>
              <div v-if='requestFormula'>{{stage2explanationsName[type][typeEntry]}}</div>
              <div v-if='!requestFormula'>{{stage2explanationsFormula[type][typeEntry]}}</div>
            </div>
            <div v-if='requestFormula'>
              <h4 v-if='type === 1'>What charges do the ions have? Enter cation and anion charge:</h4>
              <h4 v-if='type === 2'>How many of each element do we need? Enter number of first and second:</h4>
              <h4 v-if='type === 3'>What's the charge on the anion?</h4>
              <input v-focus v-model="num1" @keyup.enter="submitNum" type="text" class="form-control" autocapitalize="off" autocorrect="off">
              <input v-if='type < 3' v-focus v-model="num2" @keyup.enter="submitNum" type="text" class="form-control" autocapitalize="off" autocorrect="off">
            </div>
            <div v-if="!requestFormula">
              <h4 v-if='type === 1'>Should we use Roman numerals?</h4>
              <h4 v-if='type === 2'>Does this system use prefixes?</h4>
              <h4 v-if='type === 3'>Should the name start with 'hydro-'?</h4>
              <button @click="lastCheck(1)" class="btn btn-default"
                type="button">Yes</button>
              <button @click="lastCheck(0)" class="btn btn-default"
                type="button">No</button>
            </div>
          </div>

          <div v-if="easymode && stage > 2 && type > 0">
            <h4 v-if="successes[2]">Correct! Enter the answer!</h4>
            <h4 v-if='!successes[2]'>Oops! Try again.</h4>
            <div v-if='!successes[2] && !requestFormula && type === 1'>Use Roman numerals unless the cation is an alkali
              metal, an alkaline earth metal, aluminum or zinc.</div>
            <div v-if='!successes[2] && !requestFormula && type === 2'>The covalent system uses prefixes, though in the specific case
                of acids named as covalent compounds, prefixes are omitted.</div>
            <div v-if='!successes[2] && !requestFormula && type === 3'>Use hydro if there is no oxygen in the anion.</div>
          </div>
            <br>
          <div v-if="!easymode || stage > 3">
          <div v-if='requestFormula'>Your formatted answer is: <span v-html="this.$options.filters.formatFormula(entry)"></span></div>
          <div class="input-group">
              Your answer here:
              <input v-focus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control" autocapitalize="off" autocorrect="off">
              <span class="input-group-btn">
                <button @click="submitEntry" class="btn btn-default"
                  type="button">Submit answer!</button>
              </span>
          </div></div>
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
      requestFormula: true,
      type: 0,
      typeEntry: 0,
      romanNums: ['','I','II','III','IV','V','VI','VII', 'VIII'],
      types: ['ion', 'ionic compound', 'covalent compound', 'acid'],
      question: {name: '', formula: ''},
      stage: 0,
      successes: [],
      stage1response: '',
      stage2response: '',
      stage3response: '',
      //stage2explanations[type][typeEntry] for name given
      stage2explanationsName: [[],
        //ionic
        ['','','You can recognize an ionic compound because the first part of the name is a metal or ammonium. ',
          "This can't be an acid because the name doesn't include 'acid'. "],
        //covalent
        ['', `You can recognize a covalent compound because the name will usually include a prefix, and
          also the first element named will be a non-metal. `,
          '', "This is not named as an acid (because it doens't include 'acid') and unless it contains hydrogen, it isn't an acid at all. "],
        //acid
        ['', 'This is an acid, since it has "acid" in the name. ',
        'Acids are covalent, but since it has acid in the name, pick "acid". ', '']],
      stage2explanationsFormula: [[],
        //ionic
        ['', '', `You can tell it's ionic because it begins with either NH4 or a metal`,
        `You can tell it's not an acid because it doesn't start with H. `],
        //covalent
        ['', `You can tell it's not ionic because it starts with a non-metal (but not the NH4 group). `,
        '', `If it doesn't start with H, it can't be an acid. `],
        //acid
        ['', 'Acids are sort of similar to ionic compounds, but since it starts with H, you should call it an acid. ',
        `Acids are a type of covalent compound, but in this case we can't name it as covalent. `]
      ],
      num1: '',
      num2: '',
    }
  },
  props: ['easymode'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
      questionSetTime: 'getQuestionSetTime',
      stageData: 'getStageData',
      facts: 'getFacts',
      ions: 'getIons',
      covalentCompounds: 'getCovalentCompounds',
      feedback: 'getFeedback',
      feedbackType: 'getFeedbackType'
    }),
    cations: function() {
      let cations = this.ions.cat;
      cations.concat(this.ions.polycat);
      return cations
    },
    anions: function() {
      let anions = this.ions.an;
      anions.concat(this.ions.polyan);
      return anions
    },
    acids: function() {
      let acids = this.facts.filter(function(entry) {
        return entry.group_name === 'acids'
      })
      return acids
    }
  },
  created () {
    this.requestFormula = _.random() >= 0.5;
    this.type = _.random(0,3);
    if (this.type === 0) this.setIonQuestion();
    else if (this.type === 1) this.setIonicQuestion();
    else if (this.type === 2) this.setCovalentQuestion();
    else if (this.type === 3) this.setAcidQuestion();
  },
  methods: {
    setIonQuestion: function() {
      let catOrAn = _.random() >= 0.5;
      let ion = 0;
      if (catOrAn) {
        ion = this.cations[_.random(0, this.cations.length-1)];
      }
      else ion = this.anions[_.random(0, this.anions.length-1)];
      let question = Vue.ionNameFormula(ion)
      this.question = question
    },
    setIonicQuestion: function() {
      let setTime = this.questionSetTime;
      let anions = this.ions.an;
      let cations = this.ions.cat;
      if (this.currentQuestion[6] === 'complex ionic formulas') {
        anions.concat(this.ions.polyan);
        cations.concat(this.ions.polycat);
      }
      let anion = anions[_.random(0, anions.length-1)];
      let cation = cations[_.random(0, cations.length-1)];
      let question = Vue.ionicNameFormula(cation, anion);
      question.setTime = setTime;
      this.question = question
    },
    setCovalentQuestion: function() {
      let compounds = this.covalentCompounds;
      let compound = compounds[_.random(0, compounds.length -1)]
      let regex = /[A-Z][a-z]*(\d*)[A-Z][a-z]*(\d*)/g
      let arr = regex.exec(compound[0])
      for (let i=1; i < 3; i++) {
        if (arr[i] === '') arr[i] = '1'
      }
      console.log(arr)
      this.question = {name: compound[1], formula: compound[0], num1: arr[1], num2: arr[2]}
    },
    setAcidQuestion: function() {
      let acid = this.acids[_.random(0, this.acids.length -1)]
      let regex = /^H(\d*)/
      let arr = regex.exec(acid.key)
      if (arr[1] === '') arr[1] = '1'
      console.log(arr)
      this.question = {name: acid.prop, formula: acid.key, charge: -Number(arr[1])}
    },
    neutralOrNot: function(choice) {
      //is ion
      if (this.type === 0) {
        //picked ion correctly
        if (!choice) {
          this.successes[0] = 1
          this.stage1response = "You picked ion. "
        }
        else {
          this.successes[0] = 0
          this.stage1response = 'You picked compound, but this is an ion. '
        }
      }
      else {
        if (choice) {
          this.successes[0] = 1
          this.stage1response = "You picked compound. "
        }
        else {
          this.successes[0] = 0
          this.stage1response = "You picked ion, but this is a compound. "
        }
      }
      if (this.type !== 0) this.stage = 1
      else this.stage = 4
    },
    typeCheck: function(typeEntry) {
      this.typeEntry = typeEntry
      if (/^H/.test(this.question.formula) && !(/O/.test(this.question.formula)) && !this.requestFormula) {
        if (typeEntry > 1) {
          this.successes[1] = 1
          if (typeEntry === this.type) this.stage2response = `You picked ${this.types[this.type]}. `
          else {
            this.stage2response = `You picked ${this.types[typeEntry]}, which is reasonable, but let's use the rules for ${this.types[this.type]}s. `
          }
        }
        else {
          this.successes[1] = 0
          this.stage2response = `You picked ${this.types[typeEntry]}, but this is a ${this.types[this.type]}. `
        }
      }
      else if (typeEntry === this.type) {
        this.successes[1] = 1
        this.stage2response = `You picked ${this.types[this.type]}. `
      }
      else {
        this.successes[1] = 0
        this.stage2response = `You picked ${this.types[typeEntry]}, but this is a ${this.types[this.type]}. `
      }
      this.stage = 2
    },
    submitNum: function(event) {
      if (this.type === 1) {
        this.num1 = Number(this.num1.replace(/(\d+)([+])/g, '$2$1'))
        this.num2 = Number(this.num2.replace(/(\d+)([-])/g, '$2$1'))
        if (this.num1 === Number(this.question.catCharge) && this.num2 === -Number(this.question.anCharge)) {
          this.successes[2] = 1
        }
        else this.successes[2] = 0
      }
      else if (this.type === 2) {
        if (this.num1 === this.question.num1 && this.num2 === this.question.num2) {
          this.successes[2] = 1
        }
        else this.successes[2] = 0
      }
      else if (this.type === 3) {
        this.num1 = Number(this.num1.replace(/(\d+)([-])/g, '$2$1'))
        if (this.num1 === this.question.charge) this.successes[2] = 1
        else this.successes[2] = 0
      }
      if (this.successes[2]) this.stage = 4
      else this.stage = 3
    },
    lastCheck: function(choice) {
      if (this.type === 1) {
        if (Boolean(choice) === this.question.romNum) {
          this.successes[2] = 1
        }
        else this.successes[2] = 0
      }
      else if (this.type === 2) {
        if (choice === 1) {
          this.successes[2] = 1
        }
        else this.successes[2] = 0
      }
      else if (this.type === 3) {
        /^hydro/.test(this.question.name)
        if (/^hydro/.test(this.question.name) === Boolean(choice)) this.successes[2] = 1
        else this.successes[2] = 0
      }
      if (this.successes[2]) this.stage = 4
      else this.stage = 3
    },
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
        //this.$store.dispatch('setQuestion');
        this.$store.dispatch('setNomenclatureSession');

        //update props
        this.entry = ''
        this.typeEntry = 0
        this.tries = 0
        this.acc = 0
        this.rts = []
        this.requestFormula = _.random() >= 0.5;
        //this.type = _.random(0,3);
        this.type = 3;
        if (this.type === 0) this.setIonQuestion();
        else if (this.type === 1) this.setIonicQuestion();
        else if (this.type === 2) this.setCovalentQuestion();
        else if (this.type === 3) this.setAcidQuestion();
        this.stage = 0
        this.successes = [];
        this.stage1response = ''
        this.stage2response = ''
        this.stage3response = ''
        this.num1 = ''
        this.num2 = ''
    	}
    },

    //checks the entry, returns answerDetail
    checkEntry: function() {
      let answerDetailToReturn = {answer: this.entry, messageSent: '', correct: ''};
      console.log('this.entry: ', this.entry);
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
            else if (this.type > 0) {
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
                answerDetailToReturn.messageSent = 'Make sure your answer is formatted correctly.';
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
                if (!reArrayA) {
                  answerDetailToReturn.correct = 'unknownWrong'
                  answerDetailToReturn.messageSent = 'check your formula'
                }
                else if (parensA !== parensE) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your parentheses. ';
                }
                else if (reArrayA[1] !== reArrayE[1]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your cation or first element. ';
                }
                else if (reArrayA[3] !== reArrayE[3]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your anion or second element. ';
                }
                else if (reArrayA[2] !== reArrayE[2] || reArrayA[4] !== reArrayE[4]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check the number of ions or atoms. ';
                }
              }
            }
          }

          //if answer is name:
          else {
            //console.log(this.entry === this.question.name)
            if (this.entry === this.question.name) {
              answerDetailToReturn.correct = 'correct';
            }
            else if (this.type === 0 && this.entry === this.question.name + ' ion') {
              answerDetailToReturn.correct = 'correct'
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
                answerDetailToReturn.messageSent = 'Check the format of your answer. Include "ion" in cation names. ';
              }
              else{
                if (reArrayNE[1] !== reArrayNA[1] || reArrayNE[2] !== reArrayNA[2]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your cation, first element or acid name. ';
                }
                if (reArrayNE[3] !== reArrayNA[3]) {
                  answerDetailToReturn.correct = 'knownWrong';
                  answerDetailToReturn.messageSent += 'Check your anion, second element or spelling of "acid". ';
                }
              }
            }
          }
          return answerDetailToReturn;
        },
    }
  }
</script>
