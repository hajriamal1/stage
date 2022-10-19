import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClient } from'@angular/common/http';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './component/login/login.component';
import { RegisterComponent } from './component/register/register.component';
import { DashboardComponent } from './component/dashboard/dashboard.component';
import { FormControl, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule, HttpInterceptor, HTTP_INTERCEPTORS } from '@angular/common/http';
import { HeaderComponent } from './shared/header/header.component';
import { FooterComponent } from './shared/footer/footer.component';
import { HomeComponent } from './component/home/home.component';
import { AuthGuard } from './services/auth.guard';
import { RegisterService } from './services/register.service';
import { TokenInterceptorService } from './services/token-interceptor.service';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AdminModule } from './admin/admin.module';
import { LoggedInAuthGuardGuard } from './services/logged-in-auth-guard.guard';
import { MatIconModule } from '@angular/material/icon';
import { NgbModal, NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { VolComponent } from './admin/vol/vol.component';
import { ServicesComponent } from './services/services.component';
import { ServComponent } from './component/serv/serv.component';
import { MatCardModule} from '@angular/material/card';
import { NewsComponent } from './component/news/news.component';
import { PlanComponent } from './component/plan/plan.component';
import { DestinationComponent } from './component/destination/destination.component'
import { FlexLayoutModule } from '@angular/flex-layout';
import { ProfilComponent } from './component/profil/profil.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    DashboardComponent,
    HeaderComponent,
    FooterComponent,
    HomeComponent,
    VolComponent,
    ServComponent,
    NewsComponent,
    PlanComponent,
    DestinationComponent,
    ServicesComponent,
    ProfilComponent,
    

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
   FormsModule,
   ReactiveFormsModule,
   HttpClientModule,
   BrowserAnimationsModule,
   MatIconModule,
   AdminModule,
   NgbModule,
   MatCardModule,
   FlexLayoutModule,
   ReactiveFormsModule
   
  ],
  providers: [AuthGuard, RegisterService,
      {
        provide: HTTP_INTERCEPTORS,
        useClass: TokenInterceptorService,
        multi: true,
        
      },
    LoggedInAuthGuardGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
