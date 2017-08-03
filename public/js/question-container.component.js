var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
import { Component, Input, ViewChild, ComponentFactoryResolver } from '@angular/core';
import { QInsertDirective } from '../q-insert.directive';
import { Question } from '../question';
import { SessionManagerService } from '../../core/session-manager.service';
var QuestionContainerComponent = (function () {
    function QuestionContainerComponent(_componentFactoryResolver, sessionManagerService) {
        this._componentFactoryResolver = _componentFactoryResolver;
        this.sessionManagerService = sessionManagerService;
    }
    QuestionContainerComponent.prototype.ngOnChanges = function () {
        this.getQuestion();
    };
    QuestionContainerComponent.prototype.ngOnDestroy = function () {
    };
    QuestionContainerComponent.prototype.getQuestion = function () {
        var componentFactory = this._componentFactoryResolver.resolveComponentFactory(this.question.component);
        var viewContainerRef = this.qHost.viewContainerRef;
        viewContainerRef.clear();
        var componentRef = viewContainerRef.createComponent(componentFactory);
        componentRef.instance.data = this.question.data;
    };
    return QuestionContainerComponent;
}());
__decorate([
    Input(),
    __metadata("design:type", Question)
], QuestionContainerComponent.prototype, "question", void 0);
__decorate([
    ViewChild(QInsertDirective),
    __metadata("design:type", QInsertDirective)
], QuestionContainerComponent.prototype, "qHost", void 0);
QuestionContainerComponent = __decorate([
    Component({
        selector: 'app-question-container',
        templateUrl: './question-container.component.html',
        styleUrls: ['./question-container.component.css']
    }),
    __metadata("design:paramtypes", [ComponentFactoryResolver,
        SessionManagerService])
], QuestionContainerComponent);
export { QuestionContainerComponent };
//# sourceMappingURL=../../../../../src/app/question/question-container/question-container.component.js.map