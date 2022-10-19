import { Component, OnInit } from '@angular/core';
import { NewsService } from 'src/app/services/news.service';

@Component({
  selector: 'app-news',
  templateUrl: './news.component.html',
  styleUrls: ['./news.component.css']
})
export class NewsComponent implements OnInit {
data:any
roleConnect:any
  constructor(private newService: NewsService) { }

  ngOnInit(): void {
    this.getAll();
  }

  getAll():void{
    this.newService.getAll().subscribe((result)=>{
      console.log(result);
      this.data=result;
      this.roleConnect = localStorage.getItem("username");
    })
  }

}
