import { Injectable } from '@angular/core';
import { Headers, Http, Response } from '@angular/http';

import 'rxjs/add/operator/toPromise';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/map';

import { State } from './state';
import { User } from './user';

@Injectable()
export class LogService {
  private statesUrl = '../api/student/states';
  private actionsUrl = '../api/student/actions';
  private userUrl = '../api/student/user';
  constructor(private http: Http) { }

  getStates(): Observable<State[]> {
    return this.http.get(this.statesUrl)
               .map(this.extractData)
               .catch(this.handleError);
  }

  getUser(): Observable<User> {
    return this.http.get(this.userUrl)
                    .map(this.extractData)
                    .catch(this.handleError);
  }
  private extractData(res: Response) {
    //console.log(res);
    let body = res.json();
    //console.log(body);
    return body || { };
  }

  private handleError (error: Response | any) {
    // In a real world app, we might use a remote logging infrastructure
    let errMsg: string;
    if (error instanceof Response) {
      const body = error.json() || '';
      const err = body.error || JSON.stringify(body);
      errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
    } else {
      errMsg = error.message ? error.message : error.toString();
    }
    console.error(errMsg);
    return Observable.throw(errMsg);
  }
}
