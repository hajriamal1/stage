import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { ModalDismissReasons, NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { VolService } from 'src/app/services/vol.service';
@Component({
  selector: 'app-vol',
  templateUrl: './vol.component.html',
  styleUrls: ['./vol.component.css']
})
export class VolComponent implements OnInit {
data:any;
roleConnect:any;
closeResult: string ='';
id:any;
  constructor(private volSerice: VolService, private modalService:NgbModal, router: Router, ) { }

  ngOnInit(): void {
    this.volSerice.getVols().subscribe((result)=>{
      console.log(result);
      this.data=result;
      this.roleConnect = localStorage.getItem("username");
    })
  }

 

  open1(content:any){
    this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
      this.closeResult = `Closed with: ${result}`;
    }, (reason) => {
      this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
    });
    }

    onSubmit(form: NgForm) {
      console.log(form.value);
     this.volSerice.addVol(form.value).subscribe((res:any)=>{
      console.log('User Aded')
    })

      this.modalService.dismissAll()
      window.location.reload();
  
      
   }
  
    open(content:any,id:any ) {
      
     this.modalService.open(content, {ariaLabelledBy: 'modal-basic-title'}).result.then((result) => {
       this.closeResult = `Closed with: ${result}`;
     }, (reason) => {
       this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
     });
   }

   private getDismissReason(reason: any): string {
    if (reason === ModalDismissReasons.ESC) {
      return 'by pressing ESC';
    } else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
      return 'by clicking on a backdrop';
    } else {
      return  `with: ${reason}`;
    }
  }
  
  

}
