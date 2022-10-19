import { Component, NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AdminDashboardComponent } from './admin/admin-dashboard/admin-dashboard.component';
import { NewsAdminComponent } from './admin/news-admin/news-admin.component';
import { SrComponent } from './admin/sr/sr.component';
import { UserComponent } from './admin/user/user.component';
import { VolComponent } from './admin/vol/vol.component';
import { DashboardComponent } from './component/dashboard/dashboard.component';
import { DestinationComponent } from './component/destination/destination.component';
import { HomeComponent } from './component/home/home.component';
import { LoginComponent } from './component/login/login.component';
import { NewsComponent } from './component/news/news.component';
import { PlanComponent } from './component/plan/plan.component';
import { ProfilComponent } from './component/profil/profil.component';
import { RegisterComponent } from './component/register/register.component';
import { ServComponent } from './component/serv/serv.component';
import { AuthGuard } from './services/auth.guard';
import { LoggedInAuthGuardGuard } from './services/logged-in-auth-guard.guard';


const routes: Routes = [
  {
    path:'',
    redirectTo:'login',
    pathMatch:'full'
  },
  {
    path: 'login',
    component : LoginComponent,
    canActivate: [LoggedInAuthGuardGuard]
  },
  {
    path:'register',
    component: RegisterComponent
  },
  {
    path:'dashboard',
    component: DashboardComponent, 
    canActivate : [AuthGuard]
  },
  {
    path:'home',
    component: HomeComponent
  },
  {
    path: 'services',
    component:ServComponent
  },
  {
    path: 'news',
    component: NewsComponent
  },
  {
    path: 'plan',
    component: PlanComponent
  },
  {
    path:'destination',
    component: DestinationComponent
  },
  {
    path: 'profil',
    component:ProfilComponent,
    canActivate : [AuthGuard],
  },
  {
    path:'admin',
    component: AdminDashboardComponent,
    canActivate : [AuthGuard],
    children:[
      {
        path: "users",
        component: UserComponent
      },
      {
        path: "volAdmin",
        component:VolComponent
      },
      {
        path:"serv",
        component: SrComponent
      },
      {
        path: "newsadmin",
        component: NewsAdminComponent

      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
