import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { User } from 'src/app/services/user';
import { UserService } from 'src/app/services/user.service';
import { MatDialog } from '@angular/material/dialog';
import { ModalDismissReasons, NgbModal, NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { NgForm } from '@angular/forms';
import { ThisReceiver } from '@angular/compiler';
import { UserUpdate } from 'src/app/services/UserUpdate';


@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css']
})
export class UserComponent implements OnInit {
  UserUpdate:any
  data = new Array()
  id:any
  username:any
  email:any
  nom:any
  prenom:any
  password:any
  telephone:any
  role:any
  closeResult: string ='';
  users !: User[];
  token :any
  roleConnect :any
  emailconnect :any
  dataarrived = false
  user:any
  ListeRole = new Array()
  roleupdate!: string;
 
  constructor( private service: UserService, 
                private modalsService: NgbModal,
                router: Router
                ) { }

  ngOnInit(): void {
    this.roleConnect = localStorage.getItem("role")
    this.emailconnect = localStorage.getItem("username")
    this.getAllUsers()
  }


open1(content:any){
  this.modalsService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
    this.closeResult = `Closed with: ${result}`;
  }, (reason) => {
    this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
  });
  }

  open(content:any,id:any ) {
    
    this.id = id;
    this.service.getUserbyId(id,localStorage.getItem('currentUser')).subscribe((res)=>{
      console.log(res)
    })
   this.modalsService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
     this.closeResult = `Closed with: ${result}`;
   }, (reason) => {
     this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
   });
 }


 openUpdate(content:any,id:any ) {
    
  this.id = id;

  this.service.getUserbyId(id,localStorage.getItem('currentUser')).subscribe((res)=>{
    console.log("eeeeeeeeeeeeeeeeeeeeeeee")
    console.log(res)
   this.username=res.username
   this.nom= res.nom
   this.prenom= res.prenom
   this.email= res.email
  
   this.telephone=res.telephone

  
  })

 this.modalsService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
   this.closeResult = `Closed with: ${result}`;
 }, (reason) => {
   this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
 });
}
  private getDismissReason(reason: any): string {
    if (reason === ModalDismissReasons.ESC) {
      return 'by pressing ESC';
    } else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
      return 'by clicking on a backdrop';
    } else {
      return  `with: ${reason}`;
    }
  }

getAllUsers(){

    this.service.getUsers(localStorage.getItem('token')).subscribe(data =>{
      console.log(data);
      this.users = data;
     
    },() =>{
      console.log("erreuuuur!!!!")
    });    
  } 


 
  delete(id:any){
  
    
     this.service.deleteUser(id).subscribe((res)=>{
       
        console.log(res);
       
     })
     this.modalsService.dismissAll()
         
        
        window.location.reload();
        
   }

   updateUser(){
  
       console.log(this.user)
     
     let user = new UserUpdate(this.id,this.username,this.nom,this.prenom,this.email,this.password,this.telephone,this.role);
     this.service.updateUser(user,this.id).subscribe((res) => {

       this.getAllUsers()
       this.modalsService.dismissAll()
       

      })
    }

   

   onSubmit(form: NgForm) {
    console.log(form.value)
    this.service.addUser(form.value).subscribe((res:any)=>{
        console.log('User Aded')
        
    })
    this.modalsService.dismissAll()
    this.getAllUsers()
    window.location.reload();

    
 }

}