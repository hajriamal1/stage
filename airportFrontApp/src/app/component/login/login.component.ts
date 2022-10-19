import { JsonpClientBackend } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { RegisterService } from 'src/app/services/register.service';
import { User } from 'src/app/services/user';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  role!: string;
  userToken: any;
  user:User=new User();

  constructor(private service:RegisterService, private router:Router) { }
  

  ngOnInit(): void {
  }



  login(){
    
    console.log(this.user);
    this.service.login(this.user).subscribe((res)=>{
     alert("Connexion avec Succées ");
     console.log(res);

     /**this.user= this.getUser(res.token);*/
      
     localStorage.setItem('token',res.token);
     
     
     this.user= this.getUser(res.token);
     this.role=this.user.roles[0];
      console.log(this.user);
      console.log(this.user.username);
      console.log(this.role);
     

      localStorage.setItem("username",this.user.username);
      localStorage.setItem("role",this.role);
      

      if (this.role=="ROLE_ADMIN"){
        this.router.navigate(['/admin']);
      }else{
        this.router.navigate(['/home']);
      }

    },error=>alert("Coordonnées invalides"));
  
   

  }

getUser(token:string): User{
    return JSON.parse(atob(token.split('.')[1])) as User;
  
}

}

