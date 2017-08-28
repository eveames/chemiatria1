import _ from "lodash";
export default {
  install: function (Vue) {

    Vue.skillPriorityHelper = function(stageData) {

      //ms until next to study
      const delayWrong = 3000;
      const delayDiscover = 10000;
      const delayMaster = 240000;
      const delayReview = 1200000;
      const timesCriterionForMaster = 10; //must of studied 10x
      const accCriterionForMaster = 1; //no more than 1 wrong in last 10
      const timesCriterionForReview = 30;
      const accCriterionForReview = 1;
      const rtCriterionForReview = 10;
       //console.log("in fact priority, stageData is ", stageData)
      let timesStudied = stageData.accs.length;
      let correct = stageData.accs[timesStudied - 1];
      let stage = Number(stageData.stage);
      let newStage = 0;
      let newPriority = 0;
      let metrics = Vue.metricsHelper(stageData);
      if (timesStudied > timesCriterionForReview &&
    			metrics.accuracyLast10 <= accCriterionForReview &&
    			metrics.averageRTLast10 < rtCriterionForReview) {
    		if (stage === 'master') {
    				newStage = 'review';
 					//console.log(thisItem.type + ' ' + thisItem.subtype + ' now mastered!');
    		}
    	}
    	if (timesStudied > timesCriterionForMaster &&
    			metrics.accuracyLast10 <= accCriterionForMaster) {
    		if (stage === 'discover') {
    				newStage = 'master';
    				//console.log(thisItem.type + ' ' + thisItem.subtype + ' now discovered!');
    		}
    	}
    	stage = newStage;
    	//update priority
    	if (stage === 'discover' && correct) {
    		newPriority = stageData.lastStudied + delayDiscover;
    	}
    	else if (stage === 'master' && correct) {
    		newPriority = stageData.lastStudied + delayMaster;
    	}
    	else if (stage === 'review' && correct) {
    		newPriority = stageData.lastStudied + delayReview;
    	}
      else newPriority = stageData.lastStudied + delayWrong;
        //randomize new priority a bit
      let randomFactor = _.random(0,40) * 1000;
    	newPriority += randomFactor;
      return {priority: newPriority, stage: newStage}
    }

  Vue.metricsHelper = function(stageData) {
    let plusStart = function(start) {
      return function(a,b, c) {
        if (c < start) {return 0;}
        if (isNaN(a)) {
          a = 0;
        }
        if (isNaN(b)) {
          b = 0;
        }
        else {return a + b;}
      };
    };
    let accArray = stageData.accs;
    	//console.log('in get metrics');
    let rtArray = [];
    for (let i = 0; i < stageData.rts.length; i++) {
      rtArray[i] = stageData.rts[i].slice();
    }
    let flatRTArray = rtArray.reduce(function(a, b) {
  			return a.concat(b);
		});
        //console.log('in get metrics after flat: ', studyArrayItem.rtArray);
		let lastRTArray = rtArray.reduce(function(a,b) {
			return a.concat(b.pop());
		});
        //console.log('in get metrics after last: ', studyArrayItem.rtArray);
    let totalAccuracy = accArray.reduce(plusStart(0));
    let timesStudied = accArray.length;
    let lastMistake = Math.max(accArray.lastIndexOf(1),
    		accArray.lastIndexOf(2), accArray.lastIndexOf(3), accArray.lastIndexOf(4));
    let lastStreak = timesStudied - lastMistake;
    let accuracyLastChunk = accArray.reduce(plusStart(timesStudied - 10));
    let totalRT = flatRTArray.reduce(plusStart(0))/flatRTArray.length;
    let streakRT = lastRTArray.reduce(plusStart(lastMistake+1))/lastStreak;
        //this gives the total time to right answer (adds rt for each response to one q)
    let rtLastChunk = lastRTArray.reduce(plusStart(timesStudied - 10))/(Math.min(10, timesStudied));
        //console.log('in get metrics after before return: ', studyArrayItem.rtArray);
    return {
    		totalAccuracy: totalAccuracy, timesStudied: timesStudied,
    		lastStreak: lastStreak, accuracyLast10: accuracyLastChunk,
    		averageRT: totalRT, streakAverageRT: streakRT, averageRTLast10: rtLastChunk
    	};
    }
  }
}
