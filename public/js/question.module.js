var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { QuestionContainerComponent } from './question-container/question-container.component';
import { SigfigQuestionComponent } from './sigfig-question/sigfig-question.component';
import { SigfigService } from './sigfig-question/sigfig.service';
import { QInsertDirective } from './q-insert.directive';
var QuestionModule = (function () {
    function QuestionModule() {
    }
    return QuestionModule;
}());
QuestionModule = __decorate([
    NgModule({
        imports: [
            CommonModule
        ],
        declarations: [QuestionContainerComponent, QInsertDirective, SigfigQuestionComponent],
        providers: [SigfigService],
        entryComponents: [SigfigQuestionComponent]
    })
], QuestionModule);
export { QuestionModule };
//# sourceMappingURL=../../../../src/app/question/question.module.js.map