import _ from "lodash";
export default {
  install: function (Vue) {

    //produces a string of given length; increasing zeros increases probability
    //that any given digit in string is zero
    Vue.randomDigitString = function(length, zeros) {
      let randomString = '';
      let min, max = 0;
      if (zeros === 0) {
       min = 1;
       max = 9;
      }
      else {
       min = 0;
       max = 10 + zeros;
      }
      for(let i =0; i < length; i++) {
       let newDigit = _.random(min, max);
       if (newDigit > 9) {newDigit = 0;}
        randomString += newDigit;
      }
      return randomString;
    }
  }
} 
