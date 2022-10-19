import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, Router , CanActivate, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { RegisterService } from './register.service';


@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(private _service: RegisterService,
              private _router: Router) { }

  canActivate(): boolean{
    if (this._service.loggedIn()){
      return true;
    } else {
      this._router.navigate(['login'])
      return false
    }
  }
}
