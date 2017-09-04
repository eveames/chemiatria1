import _ from "lodash";
export default {
  install: function (Vue) {

    Vue.factPriorityHelper = function(stageData) {

      //ms until next to study
      const stageArray = [
         0,					//start
         5000,				//5s
         25000,				//25s
         120000,				//2 min
         600000,				//10 min
         86400000,			//1d
         172800000,			//2d
         345600000,			//4d
         864000000,			//10d
         2160000000,			//25d
         6000000000       // 2.5 months
       ];
       console.log("in fact priority, stageData is ", stageData)
       let timesStudied = stageData.accs.length;
       let correct = stageData.accs[timesStudied - 1];
       let stage = Number(stageData.stage);
       let newStage = 0;
       let now = Date.now();
       if (correct === 0 && timesStudied === 1) {
         newStage = 4;
       }
       else if (correct === 0) {
         if (stage = 10) newStage = 10;
         else newStage = stage + 1;
       }
       else if (correct === 1 || stage === 0) {
         newStage = stage;
       }
       else {
         newStage = stage -1;
       }
       //console.log("lastStudied is", stageData.lastStudied);
       let newPriority = now + stageArray[newStage];
       console.log('newPriority is ', newPriority);
       //insert randomization:
       let randomFactor = _.random(0, 40) * 1000;
       newPriority += randomFactor;
       console.log('with random, newPriority is ', newPriority);
       return {priority: newPriority, stage: newStage}
    }
  }
}
