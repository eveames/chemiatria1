import { Injectable } from '@angular/core';
import { LogService } from './log.service';
import { State } from './state';
import { ContentService } from './content.service';


@Injectable()
export class SessionManagerService {

  constructor(private logService: LogService, private contentService: ContentService) { }

  states: State[];
  errorMessage: any;

  setup(): void {
    this.logService.getStates().subscribe(
                     states => this.states = states,
                     error =>  this.errorMessage = <any>error
                   );
  }

}
