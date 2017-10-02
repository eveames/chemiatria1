import _ from "lodash";
//import store from '../vuex/store';
export default {
  install: function (Vue) {

    Vue.parseFormulaForStructure = function(formula) {
      let atomFinder = /([A-Z][a-z]*)(\d*)/g
      let chargeFinder = /([+|-]\d*)$/
      let tempArray = [];
      let structure = [];
      while((tempArray = atomFinder.exec(formula)) !== null) {
        if (tempArray[2] === '') tempArray[2] = 1
        for (let i = 0; i < Number(tempArray[2]); i++) {
          //0: index
          //1: num unbondedE
          //2: symbol
          //3: connections
          //4: is loop
          //5: numUnpairedE
          let atom = [0, 0, tempArray[1], [], 0, 0]
          structure.push(atom)
        }
      }
      let chargeArray = chargeFinder.exec(formula)
      //console.log(chargeArray)
      let charge = 0
      if (chargeArray) {
        //console.log(Number(chargeArray[0]))
        charge = Number(chargeArray[0])
      }
      return {structure: structure, charge: charge};
    }
    //expects central atom first, and all other atoms same element. diatomics ok, no charges
    Vue.simpleCentralStructure = function(formula, elements) {
      //console.log('in simpleCentralStructure')
      let strucObj = Vue.parseFormulaForStructure(formula)
      let struc = strucObj.structure
      let charge = strucObj.charge
      if (charge !== 0) console.log("not setup for charges yet")
      let numAtoms = struc.length
      let element = elements[struc[0][2]]
      struc[0][0] = 0
      let bonds = element[4]
      let outerBonds = 0
      for (let i = 1; i < numAtoms; i++) {
        element = elements[struc[i][2]]
        outerBonds += element[4]
      }
      console.log('outerBonds: ', outerBonds)
      if (bonds < numAtoms - 1) bonds = element[5] //use ox max valence instead of normal
      if (bonds > outerBonds) bonds = outerBonds
      if (bonds%(outerBonds) !== 0) console.log("bonds don't divide evenly over atoms")
      struc[0][1] = element[1] - bonds
      let bondsPerConnection = bonds/(numAtoms - 1)
      for(let i = 1; i < numAtoms; i++) {
        element = elements[struc[i][2]]
        struc[i][0] = i
        struc[i][1] = element[1] - bondsPerConnection
        if (!(bondsPerConnection >= element[4] && bondsPerConnection <= element[5])) console.log('bad structure! outer atoms not happy')
        console.log(bondsPerConnection, element[4], bondsPerConnection, element[5])
        struc[i][3].push([0,bondsPerConnection])
        struc[0][3].push([i,bondsPerConnection])
      }

      return {structure: struc, answer: 'y'};
    }
  }
}
