var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
import { Injectable } from '@angular/core';
import { LogService } from './log.service';
import { ContentService } from './content.service';
import { Subject } from 'rxjs/Subject';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/map';
import { SigfigQuestionComponent } from '../question/sigfig-question/sigfig-question.component';
var SessionManagerService = (function () {
    function SessionManagerService(logService, contentService) {
        this.logService = logService;
        this.contentService = contentService;
        this.question = new Subject();
    }
    SessionManagerService.prototype.setup = function () {
        var _this = this;
        this.logService.getActiveStates().subscribe(function (states) { return _this.states = states; }, function (error) { return _this.errorMessage = error; });
        this.currentQuestion.component = SigfigQuestionComponent;
        this.currentQuestion.data = { question: { number: 340, hint: "" }, answer: 2 };
        this.question.next(this.currentQuestion);
    };
    SessionManagerService.prototype.change = function (grade) {
        this.question.next(this.currentQuestion);
    };
    return SessionManagerService;
}());
SessionManagerService = __decorate([
    Injectable(),
    __metadata("design:paramtypes", [LogService, ContentService])
], SessionManagerService);
export { SessionManagerService };
//# sourceMappingURL=../../../../src/app/core/session-manager.service.js.map