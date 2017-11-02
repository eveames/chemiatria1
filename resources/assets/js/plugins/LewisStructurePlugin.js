import _ from "lodash";
//import store from '../vuex/store';
export default {
  install: function (Vue) {

    Vue.parseFormulaForStructure = function(formula, elements) {
      let atomFinder = /([A-Z][a-z]*)(\d*)/g
      let chargeFinder = /([+|-]\d*)$/
      let tempArray = [];
      let structure = [];
      let numE = 0
      while((tempArray = atomFinder.exec(formula)) !== null) {
        if (tempArray[2] === '') tempArray[2] = 1
        for (let i = 0; i < Number(tempArray[2]); i++) {
          //0: index
          //1: num unbondedE
          //2: symbol
          //3: connections
          //4: is loop
          //5: numUnpairedE
          //6: num bonds
          //7: formal charge
          //8: satisfied
          let atom = [0, 0, tempArray[1], [], 0, 0, 0, 0, 0]
          structure.push(atom)
          //console.log(elements[tempArray[1]][1])
          numE += elements[tempArray[1]][1]
        }
      }
      console.log('in parse structure is ', structure)
      let chargeArray = chargeFinder.exec(formula)
      //console.log(chargeArray)
      let charge = 0
      if (chargeArray) {
        //console.log(Number(chargeArray[0]))
        charge = Number(chargeArray[0])
      }
      numE -= charge
      return {structure: structure, charge: charge, numE: numE};
    }
    //expects central atom first, and all other atoms same element. diatomics ok, no charges
    Vue.generalLewisStructure = function(formula, elements) {
      //console.log('in simpleCentralStructure')
      let strucObj = Vue.parseFormulaForStructure(formula, elements)
      let struc = strucObj.structure
      let charge = strucObj.charge
      let numE = strucObj.numE
      //console.log(numE)
      //if (charge !== 0) console.log("not setup for charges yet")
      //console.log("struc, from parse, is ", struc)
      let numAtoms = struc.length
      //let element = elements[struc[0][2]]
      //console.log('element is: ', element)
      //struc[0][0] = 0

      // set up connections; this part needs work to make connectivity general
      //each outside atom has one bond to central only
      let unusedE = numE
      let EwantedForLP = 0
      let eToAdd = 0
      let atomsWantingBonds = []
      let atomsWantingOctet = []
      let tryNewConnectivity = 0
      let j = 0
      let i = 1
      let element = []
      //let atomsWithBigFC = []
      for(i = 1; i < numAtoms; i++) {
        element = elements[struc[i][2]]
        struc[i][0] = i
        struc[i][6] = 1
        if (1 < element[4]) atomsWantingBonds.push(i)
        struc[i][3].push([0,1])
        struc[0][3].push([i,1])
        struc[0][6] += 1
        unusedE -= 2
        if (element[2]%2 !== 0 && numE%2 === 0) EwantedForLP += element[2] - struc[i][6]*2 + 1
        else EwantedForLP += element[2] - struc[i][6]*2
        console.log(element, element[2] - struc[i][6]*2)
      }
      //check central element
      element = elements[struc[0][2]]
      if (struc[0][6] < element[6]) {
        console.log('central atom needs bonds')
        //atomsWantingBonds.push(0)
      }
      if (struc[0][6] > element[5]) {
        console.log('central atom has too many bonds already, need different structure')
        tryNewConnectivity = 1
      }
      EwantedForLP += element[2] - struc[0][6]*2
      console.log('EwantedForLP:', EwantedForLP)
      console.log('unusedE: ', unusedE)
      // add multiple bonds
      if (EwantedForLP > unusedE) {
        console.log('adding more bonds')
        //first check if central atom can have more bonds
        let maxNewBondsToCentral = element[5] - struc[0][6]
        let newBondsNeeded = (EwantedForLP - unusedE)/2
        if (newBondsNeeded > maxNewBondsToCentral) {
          console.log('need too many new bonds to central atom')
          tryNewConnectivity = 1
        }
        else {
          console.log("maxNewBondsToCentral", maxNewBondsToCentral)
          console.log('atomsWantingBonds', atomsWantingBonds)

          while (newBondsNeeded > 0) {
            i = atomsWantingBonds.shift()
            element = elements[struc[i][2]]
            struc[i][6] += 1
            if (struc[i][6] < element[4]) atomsWantingBonds.push(i)
            else if (struc[i][6] < element[5] && newBondsNeeded > atomsWantingBonds.length) atomsWantingBonds.push(i)
            struc[i][3][0][1] += 1
            console.log('struc[0][3]', struc[0][3])
            j = struc[0][3].findIndex((element) => {
              return element[0] === i
            })
            console.log('i, j, struc[0][3]', i, j, struc[0][3])
            struc[0][3][j][1] += 1
            struc[0][6] += 1
            unusedE -= 2
            EwantedForLP -= 4
            newBondsNeeded -= 1
          }
        }
      }
      //update central atom
      let happyAtoms = 0
      element = elements[struc[0][2]]
      struc[0][7] = element[1] - struc[0][1] - struc[0][6]
      if (struc[0][6] < element[6]) {
        console.log('central atom needs bonds')
        //atomsWantingBonds.push(0)
      }
      if (struc[0][6] > element[5]) {
        console.log('central atom has too many bonds already, need different structure')
        tryNewConnectivity = 1
      }

      else if (element[2] <= struc[0][1] + struc[0][6]*2 && element[3] >= struc[0][1] + struc[0][6]*2) {
        struc[0][8] = 1
        console.log('set central happy')
        happyAtoms++
      }
      console.log('element[2] <= struc[0][1] + struc[0][6] && element[3] >= struc[0][1] + struc[0][6]', element[2],struc[0][1],struc[0][6],element[3])
      //fill out octets, outer atoms first, until you run out of electrons
      if (unusedE < 0) console.log("unusedE: ", unusedE)

      j = 1

      //clean this up, combine 2 ifs
      while (unusedE > 0) {
        console.log('about to add LP')
        if (!struc[j][8]) {
          console.log('about to add LP to index: ', j)
          element = elements[struc[j][2]]
          if (element[2]%2 !== 0 && numE%2 === 0) eToAdd = element[2] - struc[j][1] - struc[j][6]*2 + 1
          else eToAdd = element[2] - struc[j][1] - struc[j][6]*2
          if (eToAdd > unusedE) eToAdd = unusedE
          else happyAtoms++
          struc[j][1] += eToAdd
          if (struc[j][1]%2 !== 0) struc[j][5] = 1
          struc[j][7] = element[1] - struc[j][1] - struc[j][6]
          struc[j][8] = 1
          if (struc[j][6] > element[5] || struc[j][6] < element[6]) console.log('bad number of bonds for index: ', j)
          unusedE -= eToAdd
          j++
          j = j%numAtoms
        }
        if (happyAtoms === numAtoms && unusedE > 0) {
          element = elements[struc[j][2]]
          if (struc[j][1] + struc[j][6]*2 < element[3]) {
            eToAdd = element[3] - (struc[j][1] + struc[j][6]*2)
            if (eToAdd > unusedE) eToAdd = unusedE
            struc[j][1] += eToAdd
            if (struc[j][1]%2 !== 0) struc[j][5] = 1
            struc[j][7] = element[1] - struc[j][1] - struc[j][6]
            struc[j][8] = 1
            if (struc[j][6] > element[5] || struc[j][6] < element[6]) console.log('bad number of bonds for index: ', j)
            unusedE -= eToAdd
            j++
            j = j%numAtoms
          }
        }
      }

      if (happyAtoms === numAtoms) return {structure: struc, answer: 'y'};
      else {
        console.log('bad structure, out of ideas')
        return {structure: struc, answer: 'n'};
      }
    }

    Vue.simpleCentralStructure = function(formula, elements) {
      //console.log('in simpleCentralStructure')
      let strucObj = Vue.parseFormulaForStructure(formula, elements)
      let struc = strucObj.structure
      let charge = strucObj.charge
      let numE = strucObj.numE
      if (charge !== 0) console.log("not setup for charges yet")
      //console.log("struc, from parse, is ", struc)
      let numAtoms = struc.length
      let element = elements[struc[0][2]]
      console.log('element is: ', element)
      struc[0][0] = 0
      let bonds = element[4] //normal num of bonds for element
      let outerBonds = 0
      let elementTemp = 0
      for (let i = 1; i < numAtoms; i++) {
        elementTemp = elements[struc[i][2]]
        outerBonds += elementTemp[4]
      }
      console.log('outerBonds: ', outerBonds)
      console.log('bonds: ', bonds)
      if (bonds < numAtoms - 1) bonds = element[5] //use ox max valence instead of normal
      if (bonds < outerBonds) {
        console.log('bonds less than outerBonds', bonds, outerBonds)
        if (outerBonds < element[5] + 1) bonds = outerBonds
      }
      if (bonds > outerBonds) bonds = outerBonds
      if (bonds%(outerBonds) !== 0) console.log("bonds don't divide evenly over atoms")
      console.log('element[1] and bonds:', element[1], bonds)
      console.log('element is: ', element)
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
