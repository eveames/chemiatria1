<template>
  <div class="panel panel-default">
      <div class="panel-heading">Lewis Tester</div>

        <div class="panel-body">
          <div>

            <br><br>
            Is this a good Lewis structure for <span v-html="this.$options.filters.formatFormula(formula)"></span>?</div>
            <div class="input-group">
              <span class="input-group-btn">
                <button @click="submitEntry" class="btn btn-default"
                  type="button">Submit answer!</button>
              </span>
            </div>
            <svg width="200" height="200">
              <lewis-atom :stats='stats'></lewis-atom>
            </svg>


            <br>

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
      index: 0,
      //determines whether name or formula is given
    }
  },
  //props: ['questionTypeID'],
  computed: {
    ...mapGetters({
      lewisHomo: 'getLewisHomoDiatomics',
      lewisHetero: 'getLewisHeteroDiatomics',
      lewisMulti: 'getLewisSimpleCentral',
      lewisTriCentral: 'getLewisTriatomicCentral',
      lewisIons: 'getLewisIons',
      elements: 'getLSE'
    }),
    formulasArray: function() {
      let temp = this.lewisHomo.concat(this.lewisHetero, this.lewisMulti, this.lewisTriCentral, this.lewisIons)
      //let temp = this.lewisTriCentral
      //let temp = this.lewisIons
      return temp
    },
    formula: function() {
      return this.formulasArray[this.index]
      //return 'SCl4'
    },
    question: function() {
      return Vue.generalLewisStructure(this.formula, this.elements, false)
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

  methods: {

    submitEntry: function(event) {

        this.index++
        //this.index = 20

    	}
    },
  }
</script>
