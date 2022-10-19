import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import {HttpClient} from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})
export class NewsService {
url="http://localhost:8000/news";
  constructor(private http: HttpClient) { }

  getAll():Observable<any>{
   return this.http.get(this.url);
  }
}
