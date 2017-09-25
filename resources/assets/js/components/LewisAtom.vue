<template>
  <g>
    <text :id="'atom' + index":x="textRect.left" :y="textRect.top" font-family="Verdana" font-size="24">{{element[0]}}</text>

  </g>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
import _ from 'lodash'

export default {
  props: ['stats'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
      elements: 'getLSE',
    }),
    index: function() {
      return this.stats.index;
    },
    atom: function() {
      return this.stats.atomsArray[this.index];
    },
    numUnbondedE: function() {
      return this.atom[1];
    },
    element: function() {
      console.log(this.elements, this.atom)
      return this.elements[this.atom[2]];
    },
    numBonds: function() {
      let numBonds = 0;
      for (let i = 0; i < this.atom.connections.length; i++){
        numBonds += i[1];
      }
      return numBonds;
    },
    numConnections: function() {
      return this.atom.connections.length;
    },
    numDomains: function() {
      return this.numConnections + _.ceil(this.numUnbondedE/2)
    },
    formalCharge: function() {
      return this.numUnbondedE + this.numBonds - this.element[1];
    },
    directions: function() {
      return this.stats.directions.slice(0);
    },
    drawnAtoms: function() {
      let temp = this.stats.drawnAtoms.slice(0);
      temp[this.index] = 1;
      return temp;
    },
    textRect: function() {
      let rect = document.getElementById('atom' + this.index).getBBox();
      let left = rect.x;
      let top = rect.y;
      let width = rect.width;
      let height = rect.height;
      let right = left + width;
      let bottom = top - height;
      let centerx = left +width/2;
      let centery = top - height/2;
      return {left: left, right: right, top: top, bottom: bottom,
        width: width, height: height, centerx: centerx, centery: centery}
    },
    numBondsAlready: function() {
      let numBondsAlready =0;
      for (let i =0; i < this.directions.length; i++) {
        numBondsAlready += this.directions[i];
      }
      if (numBondsAlready > 1) console.log('not setup for cylic molecules')
      return numBondsAlready;
    },
    domainsToDraw: function() {
      let x = 0
      if (numBondsAlready === 1) x = this.directions.index(1)
      let domains = this.numDomains;
      let posToAdd = []
      let bondsArray = []
      let doubleBondsArray = []
      let tripleBondsArray = []
      let newAtomsArray = []
      let radicalsArray = []
      let lonePairsArray = []
      let formalChargesArray = []
      if (domains === 6) posToAdd = [(x+6)%12, (x+2)%12, (x+4)%12, (x+8)%12, (x+10)%12,x]
      else if (domains === 5) posToAdd = [(x+5)%12,(x+2)%12, (x+7)%12, (x+10)%12, x]
      else if (domains === 4) posToAdd = [(x+6)%12,(x+3)%12, (x+9)%12, x]
      else if (domains === 3) posToAdd = [(x+4)%12, (x+8)%12, x]
      else if (domains === 2) posToAdd = [(x+6)%12, x]
      else if (domains === 1) posToAdd = [x]
      else console.log("error, too many domains")
      //add bond and atoms
      let bondsToDraw = this.numConnections - numBondsAlready
      //draw lines at angles defined by posToAdd
      let connections = this.atom[3]
      connections.forEach(function(item) {
        if (this.drawnAtoms[item[0]] === 0) {
          let direction = posToAdd.shift();
          if (item[1] === 1) {
            let ends = Vue.bondPositioner(this.textRect, direction);
            singleBondsArray.push({start: ends.start, end: ends.end})
          }
          if (item[1] === 2) {
            let ends = Vue.doubleBondPositioner(this.textRect, direction);
            doubleBondsArray.push({start: ends.start, end: ends.end})
          }
          if (item[1] === 3) {
            let ends = Vue.tripleBondPositioner(this.textRect, direction);
            tripleBondsArray.push({start: ends.start, end: ends.end})
          }
          //add atoms
          let directions = Array(12);
          directions.fill(0);
          let newDirectionIndex = (direction+6)%12
          directions[newDirectionIndex] = 1
          let newCenter = Vue.newAtomPositioner(this.textRect, direction)
          newAtomsArray.push({stats: {
            center: newCenter,
            directions: directions,
            atomsArray: this.stats.atomsArray,
            drawnAtoms: this.drawnAtoms,
            index: item[0]
          }})
        }
      })
      //add lone pairs and radicals
      if (this.numUnpairedE%2 === 1) {
        //radical
        let direction = posToAdd.shift()
        let position = Vue.lpPositioner(this.textRect, direction, 1)
        radicalsArray.push({position: position})
      }
      let lpToAdd = _.floor(this.numUnpairedE/2)
      for (let i = 0; i < lpToAdd; i++) {
        let direction = posToAdd.shift()
        let dotPositions = Vue.lpPositioner(this.textRect, direction, 0)
        lonePairsArray.push({first: dotPositions[0], second: dotPositions[1]})
      }
    }
  }
}
</script>
