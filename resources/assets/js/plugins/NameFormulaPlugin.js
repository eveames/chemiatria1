import _ from "lodash";
//import store from '../vuex/store';
export default {
  install: function (Vue) {

    Vue.ionNameFormula = function(ion) {
      let romanNums = ['','I','II','III','IV','V','VI','VII', 'VIII'];
      let charge = ion.charge;
      let formula = ion.formula;
      let name = '';
      if (charge < 0) {
        name = ion.name;
      }
      else {
        if (ion.romNum) {
          charge = charge[_.random(0, charge.length -1)];
          name = ion.name + '(' + romanNums[charge] + ') ion';
        }
        else {
          name = ion.name + ' ion'
        }
        if (!(/\d/g.test(ion.formula))) formula = formula + '+' + charge
      }
      return {name: name, formula: formula}
    }

    Vue.ionicNameFormula = function(cation, anion) {
      let romanNums = ['','I','II','III','IV','V','VI','VII', 'VIII'];
      let catName = '';
      let catCharge = 0;
      let formula = '';
      let name = '';
      if (cation.romNum) {
        catCharge = cation.charge[_.random(0, cation.charge.length -1)];
        catName = cation.name + '(' + romanNums[catCharge] + ')';
      }
      else {
        catName = cation.name;
        catCharge = cation.charge;
      }
      name = catName + ' ' + anion.name;

      let regex1 = /[\w]+/g;
    	let anArray = anion.formula.match(regex1);
      let catArray = cation.formula.match(regex1);
    	//console.log(catArray, anArray);
    	let anionCharge = anArray[1];
    	let anNum = catCharge;
    	let catNum = anionCharge;
    	if (anNum % 2 === 0 && catNum % 2 === 0) {
    		anNum /= 2;
    		catNum /= 2;
    	}
    	if (anNum % 3 === 0 && catNum % 3 === 0) {
    		anNum /= 3;
    		catNum /= 3;
    	}
  		//console.log(typeof anNum, anNum);
    	if (Number(anNum) === 1) {anNum = '';}
    	if (Number(catNum) === 1) {catNum = '';}

    	//check for more than 1 capital letter in anArray[0], catArray[0] to see if () needed
    	let regex2 = /[A-Z]/g;
    	let anNumEl = anArray[0].match(regex2).length;
    	let catNumEl = catArray[0].match(regex2).length;

    	let anFormula, catFormula = '';

    	if (anNumEl > 1 && anNum) {
    		anFormula = '(' + anArray[0] + ')';
    	}
    	else { anFormula = anArray[0];}

    	if (catNumEl > 1 && catNum) {
    		catFormula = '(' + catArray[0] + ')';
    	}
    	else { catFormula = catArray[0];}

    	formula = catFormula + catNum + anFormula + anNum;
      return {name: name, formula: formula, catCharge: catCharge, anCharge: anionCharge, romNum: cation.romNum};
    }
  }
}
