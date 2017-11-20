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
      let octetTotalMax = 0
      let octetTotalMin = 0
      let extraEToAdd = 0
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
          octetTotalMin += elements[tempArray[1]][2]
          octetTotalMax += elements[tempArray[1]][3]
          if (elements[tempArray[1]][2] === 7) extraEToAdd++
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
      if (numE%2 === 0) octetTotalMin += extraEToAdd
      return {structure: structure, charge: charge, numE: numE, octetTotalMax: octetTotalMax, octetTotalMin: octetTotalMin};
    }
    //expects central atom first, and all other atoms same element. diatomics ok, no charges
    Vue.generalLewisStructure = function(formula, elements, maxBonds) {
      let strucObj = Vue.parseFormulaForStructure(formula, elements)
      let struc = strucObj.structure
      let charge = strucObj.charge
      let numE = strucObj.numE
      let maxBondsForOctet = _.floor((strucObj.octetTotalMax - numE)/2)
      let minBondsForOctet = _.ceil((strucObj.octetTotalMin - numE)/2)
      console.log("maxBondsForOctet, minBondsForOctet", maxBondsForOctet, minBondsForOctet)
      let numAtoms = struc.length
      let numBonds = 0
      let maxNewBondsToCentral = 0

      // set up connections; this part needs work to make connectivity general
      //each outside atom has one bond to central only
      let unusedE = numE
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
        numBonds++
        //if (element[2]%2 !== 0 && numE%2 === 0) EwantedForLP += element[2] - struc[i][6]*2 + 1
        //else EwantedForLP += element[2] - struc[i][6]*2
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

      // add multiple bonds
      if (numBonds < minBondsForOctet) {
        console.log('adding more bonds')
        //first check if central atom can have more bonds
        maxNewBondsToCentral = element[5] - struc[0][6]
        let newBondsNeeded = minBondsForOctet - numBonds
        if (newBondsNeeded > maxNewBondsToCentral) {
          console.log('need too many new bonds to central atom')
          tryNewConnectivity = 1
        }

          console.log("maxNewBondsToCentral", maxNewBondsToCentral)
          console.log('atomsWantingBonds', atomsWantingBonds)
          while (newBondsNeeded > 0) {
            i = atomsWantingBonds.shift()
            //console.log('newBondsNeeded, outerAtomsWithMaxNormalBonds, i, atomsToGiveBonds', newBondsNeeded, outerAtomsWithMaxNormalBonds, i, atomsToGiveBonds)
            element = elements[struc[i][2]]
            struc[i][6] += 1
            if (struc[i][6] < element[4]) atomsWantingBonds.push(i)
            else if (struc[i][6] < element[5] && newBondsNeeded > atomsWantingBonds.length) {
              atomsWantingBonds.push(i)
            }
            struc[i][3][0][1] += 1
            //console.log('struc[0][3]', struc[0][3])
            j = struc[0][3].findIndex((element) => {
              return element[0] === i
            })
            //console.log('i, j, struc[0][3]', i, j, struc[0][3])
            struc[0][3][j][1] += 1
            struc[0][6] += 1
            unusedE -= 2
            //EwantedForLP -= 4
            newBondsNeeded -= 1
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
        //happyAtoms++
      }
      console.log('element[2] <= struc[0][1] + struc[0][6] && element[3] >= struc[0][1] + struc[0][6]', element[2],struc[0][1],struc[0][6],element[3])
      //fill out octets, outer atoms first, until you run out of electrons
      if (unusedE < 0) console.log("unusedE: ", unusedE)

      j = 1

      //clean this up, combine 2 ifs
      let k = 0
      while (unusedE > 0 && k < 6) {
        //console.log('about to add LP')
          console.log('about to add LP to index: ', j)
          console.log('happyAtoms: ', happyAtoms)
          console.log(struc[j])
          element = elements[struc[j][2]]
          if (element[2]%2 !== 0 && numE%2 === 0) eToAdd = element[2] - struc[j][1] - struc[j][6]*2 + 1
          //console.log()
          else if (happyAtoms >= numAtoms - 1 && unusedE > 0) {
            eToAdd = element[3] - (struc[j][1] + struc[j][6]*2)
          }
          else eToAdd = element[2] - struc[j][1] - struc[j][6]*2
          console.log('eToAdd, unusedE: ', eToAdd, unusedE)
          if (eToAdd > unusedE || eToAdd < 0) eToAdd = unusedE
          else happyAtoms++
          struc[j][1] += eToAdd
          if (struc[j][1]%2 !== 0) struc[j][5] = 1
          struc[j][7] = element[1] - struc[j][1] - struc[j][6]
          struc[j][8] = 1
          if (struc[j][6] > element[5] || struc[j][6] < element[6]) console.log('bad number of bonds for index: ', j)
          console.log('eToAdd: ', eToAdd)
          unusedE -= eToAdd
          j++
          j = j%numAtoms
          console.log('unusedE: ', unusedE)
          k++
      }

      //check for formal charges next to each other
      // 0: central atom FC
      //1: number of outer atoms with neg fc
      //2: number of outer atoms with pos fc
      let formalChargeArray = [0, 0, 0]
      for (i = 0; i < numAtoms; i++) {
        if (i === 0) formalChargeArray[0] = struc[i][7]
        else if (struc[i][7] < 0) formalChargeArray[1]++
        else if (struc[i][7] > 0) formalChargeArray[2]++
      }
      element = elements[struc[0][2]]
      maxNewBondsToCentral = _.floor(element[3]/2 - struc[0][1]/2 - struc[0][6])

      if (formalChargeArray[0] > 0 && maxBonds) {
        while (struc[0][7] > 0 && maxNewBondsToCentral > 0) {
          i = struc.reduce((iMin, x, i, arr) => x[7] < arr[iMin][7] ? i : iMin, 0);
          console.log('adding bond to element ', i)
          element = elements[struc[i][2]]
          struc[i][1] -= 2
          struc[i][3][0][1]++
          struc[i][6]++
          struc[i][7] = element[1] - struc[i][1] - struc[i][6]
          j = struc[0][3].findIndex((element) => {
            return element[0] === i
          })
          struc[0][3][j][1]++
          struc[0][6]++
          element = elements[struc[0][2]]
          struc[0][7] = element[1] - struc[0][1] - struc[0][6]
          maxNewBondsToCentral--
        }
      }
      if (formalChargeArray[0] < 0 && formalChargeArray[1] > 0) {
        //neg charges on both, remove a double bond
        for (i = 1; i < numAtoms; i++) {
          if (struc[i][6] > 1 && struc[i][7] >= 0) {
            console.log('moving bond on element ', i)
            element = elements[struc[i][2]]
            struc[i][1] += 2
            struc[i][3][0][1]--
            struc[i][6]--
            struc[i][7] = element[1] - struc[i][1] - struc[i][6]
            j = struc[0][3].findIndex((element) => {
              return element[0] === i
            })
            struc[0][3][j][1]--
            struc[0][6]--
            element = elements[struc[0][2]]
            struc[0][7] = element[1] - struc[0][1] - struc[0][6]
            break
          }
        }
      }
      else if (formalChargeArray[0] > 0 && formalChargeArray[2] > 0) {
        //pos charges on both, ??
        console.log('positive charges on both central atom and an outside atom, yikes!')
      }

      if (happyAtoms === numAtoms) return {structure: struc, answer: 'y'};
      else {
        console.log('bad structure, out of ideas')
        return {structure: struc, answer: 'n'};
      }
    }
  }
}
