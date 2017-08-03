import { Directive, ViewContainerRef } from '@angular/core';

@Directive({
  selector: '[q-host]'
})
export class QInsertDirective {

  constructor(public viewContainerRef: ViewContainerRef) { }

}
