import { Component, OnInit } from '@angular/core';
import { NewsService } from 'src/app/services/news.service';

@Component({
  selector: 'app-news-admin',
  templateUrl: './news-admin.component.html',
  styleUrls: ['./news-admin.component.css']
})
export class NewsAdminComponent implements OnInit {

  data:any
roleConnect:any
  constructor(private newService: NewsService) { }

  ngOnInit(): void {
    this.roleConnect = localStorage.getItem("username");
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
