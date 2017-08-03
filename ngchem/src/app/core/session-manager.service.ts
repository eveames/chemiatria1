import { Injectable } from '@angular/core';
import { LogService } from './log.service';
import { State } from './state';
import { ContentService } from './content.service';
import { Question } from '../question/question';
import { ReplaySubject } from 'rxjs/ReplaySubject';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/map';
import { StudyItem } from '../shared/study-item';
import { Grade } from '../shared/grade';
import { SigfigQuestionComponent } from '../question/sigfig-question/sigfig-question.component';


@Injectable()
export class SessionManagerService {

  constructor(private logService: LogService, private contentService: ContentService) { }

  states: State[];
  errorMessage: any;
  currentQuestion: Question;
  question = new ReplaySubject<Question>(1);
  emptyArray: number[];
  finished: number = 0;
  areWords: number = 0;
  areFacts: number = 0;

  //this tracks the studyItems in the session
  //
  studyItemArray: StudyItem[];

  //this function is called from OnInit of AppComponent
  //it sets up the studyItemArray based on states received from logService
  //then it sends out first question
  setup(): void {
    let emptyArray = new Array(100);
    for(let i = 0; i < 100; i++) emptyArray[i] = -1;
    this.logService.getActiveStates().subscribe(
                     states => this.states = states,
                     error =>  this.errorMessage = <any>error
                   );
    //setup studyItemArray
    this.studyItemArray = this.states.map(function(state) {
      let id = state.id;
      let type_id = state.type_id;
      let priority = state.priority;
      let stage = Number(state.stage);
      let accs = JSON.parse(state.accs) || emptyArray;
      let rts = JSON.parse(state.rts) || emptyArray;
      let type = -1;
      switch(state.type){
        case 'word':
          type = 1;
          this.areWords = 1;
          break;
        case 'fact':
          type = 2;
          this.areFacts = 1;
          break;
        case 'skill':
          type = 3;
          break;
        }
      return new StudyItem(id, type, type_id, priority, stage, accs, rts)
    })
    //setup ContentService
    if(this.areWords) this.contentService.getWords();
    if(this.areFacts) this.contentService.getFacts();
    //get first question
    this.currentQuestion = new Question(SigfigQuestionComponent, 1);
    this.question.next(this.currentQuestion);
  }

  studyItemToQuestion(studyItem: StudyItem): Question {
    let type_id: number = studyItem.type_id;
    switch(studyItem.type){
      case 1:
        this.currentQuestion = new Question(WordQuestionComponent, type_id);
        break;
      case 2:
        this.currentQuestion = new Question(FactQuestionComponent, type_id);
        break;
//this should break up; would be different component depending on type_id
      case 3:
        this.currentQuestion = new Question(SigfigQuestionComponent, type_id);
        break;
      }
  }
  nextStudyItem(): StudyItem {
    let readiest: StudyItem;
    let readiestUnready: StudyItem;
    let currentTime: number = Date.now();
    let studyArray: StudyItem[] = this.studyItemArray;
    for (let i: number = 0; i < studyArray.length; i++) {
    		if (studyArray[i].priority === 1) {
    			if (readiest) {return readiest;}
    			else {return studyArray[i];}
    		}
    		else if (studyArray[i].priority <= currentTime) {
    			if (readiest) {
    				if (readiest.priority > studyArray[i].priority) {
    				readiest = studyArray[i];
    				}
    			}
    			else {readiest = studyArray[i];}
    		}
    		else {
    			if (readiestUnready) {
    				if (readiestUnready.priority > studyArray[i].priority) {
    					readiestUnready = studyArray[i];
    				}
    			}
    			else {readiestUnready = studyArray[i];}
    		}
    	}
    	//console.log(readiest);
    	if (readiest) {return readiest;}
    	else {
            if (readiestUnready.priority > currentTime + 1800000) {this.finished = 1;}
            return readiestUnready;
        }

  }



  change(grade: Grade):  void {
    //update studyItemArray
    //log state update, actions
    //choose new question
    this.question.next(this.currentQuestion);


  }



}
