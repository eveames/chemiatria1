var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
import { Component } from '@angular/core';
import { SessionManagerService } from './core/session-manager.service';
import { LogService } from './core/log.service';
var AppComponent = (function () {
    function AppComponent(sessionManagerService, logService) {
        this.sessionManagerService = sessionManagerService;
        this.logService = logService;
        this.title = 'app works!';
    }
    AppComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.logService.getUser().subscribe(function (user) { return _this.user = user; }, function (error) { return _this.errorMessage = error; });
        this.sessionManagerService.setup();
        this.sessionManagerService.question.subscribe(function (question) { return _this.question = question; }, function (error) { return _this.errorMessage = error; });
    };
    AppComponent.prototype.ngOnDestroy = function () {
        this.sessionManagerService.question.unsubscribe();
    };
    return AppComponent;
}());
AppComponent = __decorate([
    Component({
        selector: 'app-root',
        templateUrl: './app.component.html',
        styleUrls: ['./app.component.css']
    }),
    __metadata("design:paramtypes", [SessionManagerService, LogService])
], AppComponent);
export { AppComponent };
//# sourceMappingURL=../../../src/app/app.component.js.map