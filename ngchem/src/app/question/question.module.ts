import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { QuestionContainerComponent } from './question-container/question-container.component';
import { SigfigQuestionComponent } from './sigfig-question/sigfig-question.component';
import { SigfigService } from './sigfig-question/sigfig.service';
import { QInsertDirective } from './q-insert.directive';
import { QComponent } from './q-component';
import { Question } from './question';
import { WordQuestionComponent } from './word-question/word-question.component';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [QuestionContainerComponent, QInsertDirective, SigfigQuestionComponent, WordQuestionComponent],
  exports: [QuestionContainerComponent, SigfigQuestionComponent, WordQuestionComponent],
  providers: [SigfigService],
  entryComponents: [SigfigQuestionComponent, WordQuestionComponent]
})
export class QuestionModule { }
