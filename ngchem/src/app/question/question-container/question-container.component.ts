import { Component, Input, OnChanges, ViewChild,
  ComponentFactoryResolver, OnDestroy } from '@angular/core';
import { QInsertDirective } from '../q-insert.directive';
import { Question } from '../question';
import { SessionManagerService } from '../../core/session-manager.service';
import { QComponent } from '../q-component';


@Component({
  selector: 'app-question-container',
  templateUrl: './question-container.component.html',
  styleUrls: ['./question-container.component.css']
})
export class QuestionContainerComponent implements OnChanges, OnDestroy {

  @Input() question: Question;
  @ViewChild(QInsertDirective) qHost: QInsertDirective;
  subscription: any;
  interval: any;
  constructor(private _componentFactoryResolver: ComponentFactoryResolver,
    private sessionManagerService: SessionManagerService) { }
  ngOnChanges() {
    if(this.question){
      this.getQuestion();
    }
  }
  ngOnDestroy() {
    //clearInterval(this.interval);
  }
  getQuestion() {
    console.log(this.question);
    let componentFactory = this._componentFactoryResolver.resolveComponentFactory(this.question.component);
    let viewContainerRef = this.qHost.viewContainerRef;
    viewContainerRef.clear();
    let componentRef = viewContainerRef.createComponent(componentFactory);
    (<QComponent>componentRef.instance).data = this.question.data;
  }

}
