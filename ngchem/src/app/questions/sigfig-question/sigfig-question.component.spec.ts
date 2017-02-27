import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SigfigQuestionComponent } from './sigfig-question.component';

describe('SigfigQuestionComponent', () => {
  let component: SigfigQuestionComponent;
  let fixture: ComponentFixture<SigfigQuestionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SigfigQuestionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SigfigQuestionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
