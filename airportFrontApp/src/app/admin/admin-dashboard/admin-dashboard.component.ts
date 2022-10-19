import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-admin-dashboard',
  templateUrl: './admin-dashboard.component.html',
  styleUrls: ['./admin-dashboard.component.css']
})
export class AdminDashboardComponent implements OnInit {

  sideBarOpen= true;
  a!:any;
  constructor() { }

  ngOnInit(): void {
  }
  sideBarToggler(a:any){
    this.sideBarOpen= !this.sideBarOpen;

  }

}
