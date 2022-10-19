import { Component, OnInit } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { RegisterService } from 'src/app/services/register.service';
import { User } from 'src/app/services/user';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent {
  user!: User
  role : any
  constructor(private  router: Router, public service:RegisterService) { 
   
  }

  ngOnInit(): void {
    
    this.verifRole();
  }

  verifRole(): Boolean{
    if (localStorage.getItem('role')== 'ROLE_ADMIN'){
      return true;
    } else{
      return false
    }
  }
 


}
