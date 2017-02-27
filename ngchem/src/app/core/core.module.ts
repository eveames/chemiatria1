import {
  ModuleWithProviders, NgModule,
  Optional, SkipSelf }       from '@angular/core';
import { CommonModule } from '@angular/common';
import { RandomService } from './random.service';
import { LogService } from './log.service';
import { ContentService } from './content.service';
import { SessionManagerService} from './session-manager.service';
import { State } from './state';
import { User } from './user';

@NgModule({
  imports: [
    CommonModule
  ],
  declarations: [],
  providers: [
    RandomService,
    LogService,
    ContentService,
    SessionManagerService]
})
export class CoreModule {
  constructor (@Optional() @SkipSelf() parentModule: CoreModule) {
  if (parentModule) {
    throw new Error(
      'CoreModule is already loaded. Import it in the AppModule only');
  }
}
  static forRoot(): ModuleWithProviders {
    return {
      ngModule: CoreModule,
      providers: [
        RandomService,
        LogService,
        ContentService,
        SessionManagerService
      ]
    };
  }
}
