import { Injectable } from '@angular/core';
import { HttpClient } from'@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class VolService {

url= 'http://localhost:8000/vol';
  constructor(private http: HttpClient) { }

  getVols():Observable<any>{
    return this.http.get(this.url);
  }

  addVol(data:any):Observable<any>{
    return this.http.post(`${this.url}`, data);
  }
  getVolbyId(id:any):Observable<any>{
    
    ;
    return this.http.get("http://localhost:8000/vol"+id)
   }
  
   getUserByUsername(username:any):Observable<any>{
    return this.http.get('http://localhost:8000/username/'+username);
   }

   getVolByVille(villeDepart:any,villeArrivee:any):Observable<any>{
    return this.http.get('http://localhost:8000/'+villeDepart+villeArrivee);
   }
}
