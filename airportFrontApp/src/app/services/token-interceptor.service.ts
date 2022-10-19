import { Injectable, Injector, INJECTOR } from '@angular/core';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs';
import { RegisterService } from './register.service';


@Injectable({
  providedIn: 'root'
})
export class TokenInterceptorService implements HttpInterceptor {

  constructor(private injector: Injector) { }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let registerService = this.injector.get(RegisterService)
    let tokenizedReq= req.clone({
      setHeaders: {
        Authorization: `Bearer ${registerService.getToken()}`
      }
    })
    return next.handle(tokenizedReq)
  }

}
