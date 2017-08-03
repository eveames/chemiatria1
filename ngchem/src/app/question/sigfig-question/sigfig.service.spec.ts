import { TestBed, inject } from '@angular/core/testing';
import { SigfigService } from './sigfig.service';

describe('SigfigService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [SigfigService]
    });
  });

  it('should ...', inject([SigfigService], (service: SigfigService) => {
    expect(service).toBeTruthy();
  }));
});
