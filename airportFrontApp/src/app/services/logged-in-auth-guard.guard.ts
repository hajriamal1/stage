import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, Router , CanActivate, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { RegisterService } from './register.service';
@Injectable({
  providedIn: 'root'
})
export class LoggedInAuthGuardGuard implements CanActivate {

  constructor(private _service: RegisterService,
    private _router: Router) { }

    canActivate(): boolean{
      if (this._service.loggedIn()){
        this._router.navigate(['/home'])
        return false;
      } else {
        
        return true
      }
    }
  
}
