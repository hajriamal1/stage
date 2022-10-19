import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ServService } from 'src/app/services/serv.service';

@Component({
  selector: 'app-sr',
  templateUrl: './sr.component.html',
  styleUrls: ['./sr.component.css']
})
export class SrComponent implements OnInit {

  data:any
roleConnect:any
  constructor(private ser :ServService) { }

  ngOnInit(): void {

    this.getServices();
  }

  getServices():void{
    this.ser.getAll().subscribe((result)=>
    {
      console.log(result);
      this.data=result;
      this.roleConnect = localStorage.getItem("username");
    })
  }
}
