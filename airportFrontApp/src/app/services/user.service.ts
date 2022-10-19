import { HttpClient,HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { User } from './user';

@Injectable({
  providedIn: 'root'
})
export class UserService {
 
  baseUrl="http://localhost:8000/api/users"
  constructor(private httpClient: HttpClient, private route:Router) { }

 /* getUsers(token:any):Observable<any>{

    token= localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });

    const requestOptions = { headers: headers };

   
    return this.httpClient.get("http://localhost:8000/api/users", requestOptions );

  }
  */
 getUsers(token:any) : Observable<any>{

  token= localStorage.getItem('token');
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });
    const requestOptions = { headers: headers };

  return this.httpClient.get("http://localhost:8000/api/users", requestOptions);
 }

 getUserbyId(id:any,token:any):Observable<any>{
  token= localStorage.getItem('token');
  const headers = new HttpHeaders({
    'Content-Type': 'application/json',
    'Authorization': `Bearer ${token}`
  });
  const requestOptions = { headers: headers };
  return this.httpClient.get("http://localhost:8000/api/user/"+id,requestOptions)
 }

 addUser(user:any):Observable<any>{
  const headers = new HttpHeaders({'Access-Control-Allow-Origin':'*'});
  return this.httpClient.post<User>("http://localhost:8000/api/save",user,{headers:headers})
 }

 updateUser(user:any,id:any):Observable<any>{
  const headers = new HttpHeaders({'Access-Control-Allow-Origin':'*'});
  return this.httpClient.put("http://localhost:8000/api/update/"+id,user,{headers:headers});

}
 
deleteUser(id:any): Observable<any>{
  const headers = new HttpHeaders({'Content-Type':'application/json'});
  return this.httpClient.delete("http://localhost:8000/api/delete/"+id)
 }

}
