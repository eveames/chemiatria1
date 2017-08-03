import { Component, OnInit, Input } from '@angular/core';
import {Question } from '../question';
import { Answer } from '../../shared/answer';
import { Grade } from '../../shared/grade';

@Component({
  selector: 'app-sigfig-question',
  templateUrl: './sigfig-question.component.html',
  styleUrls: ['./sigfig-question.component.css']
})
export class SigfigQuestionComponent implements OnInit {
  @Input() type_id: number;
  grade: Grade;
  timeDisplayed: number;
  timeLastAction: number;
  constructor() { }

  ngOnInit() {
    console.log(this.type_id);
    this.timeDisplayed = Date.now();
    this.timeLastAction = Date.now();
  }

  submit(input: string) {
    let timeSubmitted = Date.now();
    let rt: number = timeSubmitted - this.timeLastAction;
    this.timeLastAction = timeSubmitted;
  }

  checkMethod(answer: number, inStr: string): Answer {
            let answerToReturn = new Answer;
            answerToReturn.answer = inStr;
            let input: number = Number(inStr);

            if (input === answer) {
                answerToReturn.correct = 'correct';
            }
            //answerDetailToReturn.detail = {};
            else if (!answerToReturn.correct) {
                //check this logic
                if (input === NaN) {
                    answerToReturn.correct = 'formatError';
                    answerToReturn.message = 'Answer should be a number. ';
                }
                else if (input % 1 !== 0) {
                    answerToReturn.correct = 'formatError';
                    answerToReturn.message = 'Answer should be an integer. ';
                }
          }
          else {
            answerToReturn.correct = 'incorrect';
          }
          return answerToReturn;
        };
}
