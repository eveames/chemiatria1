import { Type } from '@angular/core';

//specify the type of component and data to bind
export class Question {
  constructor(public component: Type<any>, public type_id: number) {}
}
