import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WordQuestionComponent } from './word-question.component';

describe('WordQuestionComponent', () => {
  let component: WordQuestionComponent;
  let fixture: ComponentFixture<WordQuestionComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WordQuestionComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WordQuestionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
