import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SrComponent } from './sr.component';

describe('SrComponent', () => {
  let component: SrComponent;
  let fixture: ComponentFixture<SrComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SrComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SrComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
