import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from './user';
import { Router } from '@angular/router';
import { Token } from '@angular/compiler';
@Injectable({
  providedIn: 'root'
})
export class RegisterService {

  private decodedToken!: any;
  baseUrl="http://localhost:8000/register";

  constructor(private httpClient: HttpClient, private router: Router) {
    this.httpClient=httpClient;
  }

    registerUser(user: User): Observable<any>{
      console.log(user);
      const headers = new HttpHeaders({'Access-Control-Allow-Origin':'*'});
      return this.httpClient.post(`${this.baseUrl}`,user,{headers:headers});   
     }

     login(user: User): Observable<any>{
      const headers = new HttpHeaders({'Access-Control-Allow-Origin':'*'});
    return this.httpClient.post("http://localhost:8000/api/login",user);
    }

     loggedIn(){
      return !!localStorage.getItem('token');
     }

     getToken(){
      return localStorage.getItem('token');
     }

     logoutUser(){
      localStorage.removeItem('token');
      localStorage.clear();
      this.router.navigate(['/home']);
     }

   
   
}
