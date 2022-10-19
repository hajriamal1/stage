import { Component, OnInit } from '@angular/core';
import { VolService } from 'src/app/services/vol.service';

@Component({
  selector: 'app-profil',
  templateUrl: './profil.component.html',
  styleUrls: ['./profil.component.css']
})
export class ProfilComponent implements OnInit {
data:any
test:any
username:any
email:any
  constructor(private service:VolService ) { }

  ngOnInit():void {
    
    this.username = localStorage.getItem("username")
    console.log(this.username)
    this. getUser()
    
  }


  getUser():void{
     this.service.getUserByUsername(localStorage.getItem("username")).subscribe((result)=>
      {
        console.log(result);
        this.data=result;
      })
      console.log("heloooooo")
      
    }

}
