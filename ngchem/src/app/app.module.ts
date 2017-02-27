import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import { AppComponent } from './app.component';
import { SigfigQuestionComponent } from './questions/sigfig-question/sigfig-question.component';
import { CoreModule }       from './core/core.module';

@NgModule({
  declarations: [
    AppComponent,
    SigfigQuestionComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    CoreModule.forRoot()
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
