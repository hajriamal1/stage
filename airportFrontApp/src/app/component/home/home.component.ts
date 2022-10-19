import { CloseScrollStrategy } from '@angular/cdk/overlay';
import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { VolService } from 'src/app/services/vol.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  villeDepart:any
  villeArrivee:any
  data:any
  dateVol:any
roleConnect:any
username:any
user:any
vol:any
  constructor(private volSer:VolService) { }

  ngOnInit(): void {
    this.getAllVols()
    this.roleConnect = localStorage.getItem("username");
    this.username= localStorage.getItem("username")
  }
  getAllVols():void{
    this.volSer.getVols().subscribe((result)=>{
      this.data=result;
      
      return this.data
    })
  }

  recherche():void{
    console.log("testtt")
     
  }
  reserve(){

    if  (  (this.getUser(localStorage.getItem("username"))) && (this.getVolByVille(this.villeDepart,this.villeArrivee)) ){
        console.log("ajouter la fonction ajouter billet")
      
    }
    return true
  }

  getUser(username:any){
   this.user= this.volSer.getUserByUsername(username).subscribe((result)=>{
   this.data=result
   
  })
   return this.data
  }

  getVolByVille(villeDepart:any, villeArrivee:any){
    this.vol=this.volSer.getVolByVille(villeDepart,villeArrivee).subscribe((result)=>{
      this.data=result
      console.log(this.data)
    })
    return this.data
  }

}
