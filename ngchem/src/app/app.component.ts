import { Component, Input, OnInit, OnDestroy } from '@angular/core';
import { SessionManagerService } from './core/session-manager.service';
import { LogService } from './core/log.service';
import { User } from './core/user';
import { Question } from './question/question';
import { QuestionContainerComponent } from './question/question-container/question-container.component';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit, OnDestroy {
  title = 'app works!';
  user: User;
  errorMessage: any;
  question: Question;

  constructor(private sessionManagerService: SessionManagerService, private logService: LogService) {}

  ngOnInit(): void {
    /*this.logService.getUser().subscribe(
                     user => this.user = user,
                     error =>  this.errorMessage = <any>error
                   );*/
    //setup

    this.sessionManagerService.setup();
    console.log('about to subscribe');
    this.sessionManagerService.question.subscribe(
        question => this.question = question,
        error => this.errorMessage = <any>error
    );
    this.sessionManagerService.question.subscribe(
        question => console.log(question),
        error => this.errorMessage = <any>error
    );

  }

  ngOnDestroy(): void {
    this.sessionManagerService.question.unsubscribe();
  }

}
