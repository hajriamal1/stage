import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ServService } from 'src/app/services/serv.service';

@Component({
  selector: 'app-serv',
  templateUrl: './serv.component.html',
  styleUrls: ['./serv.component.css']
})
export class ServComponent implements OnInit {
data:any
roleConnect:any
  constructor(private ser :ServService, private router : Router) { }

  ngOnInit(): void {
    console.log("testt11")

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
