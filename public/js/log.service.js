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
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/map';
var LogService = (function () {
    function LogService(http) {
        this.http = http;
        this.statesUrl = '../api/student/states';
        this.actionsUrl = '../api/student/actions';
        this.userUrl = '../api/student/user';
    }
    LogService.prototype.getStates = function () {
        return this.http.get(this.statesUrl)
            .map(this.extractData)
            .catch(this.handleError);
    };
    LogService.prototype.getActiveStates = function () {
        return this.http.get(this.statesUrl + '/active')
            .map(this.extractData)
            .catch(this.handleError);
    };
    LogService.prototype.getUser = function () {
        return this.http.get(this.userUrl)
            .map(this.extractData)
            .catch(this.handleError);
    };
    LogService.prototype.extractData = function (res) {
        var body = res.json();
        return body || {};
    };
    LogService.prototype.handleError = function (error) {
        var errMsg;
        if (error instanceof Response) {
            var body = error.json() || '';
            var err = body.error || JSON.stringify(body);
            errMsg = error.status + " - " + (error.statusText || '') + " " + err;
        }
        else {
            errMsg = error.message ? error.message : error.toString();
        }
        console.error(errMsg);
        return Observable.throw(errMsg);
    };
    return LogService;
}());
LogService = __decorate([
    Injectable(),
    __metadata("design:paramtypes", [Http])
], LogService);
export { LogService };
//# sourceMappingURL=../../../../src/app/core/log.service.js.map