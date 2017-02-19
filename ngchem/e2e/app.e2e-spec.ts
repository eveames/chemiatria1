import { NgchemPage } from './app.po';

describe('ngchem App', () => {
  let page: NgchemPage;

  beforeEach(() => {
    page = new NgchemPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
