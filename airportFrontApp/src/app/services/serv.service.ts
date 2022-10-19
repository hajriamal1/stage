import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient,HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ServService {

  baseUrl="http://localhost:8000/service"
  constructor(private httpClient: HttpClient, private route:Router) { }

  getAll(): Observable<any>{
    return this.httpClient.get(this.baseUrl);
  }

  
}
