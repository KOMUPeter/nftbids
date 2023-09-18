import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { LogoutComponent } from './logout/logout.component';
import {HomeComponent} from "../home/home.component";

const routes: Routes = [
    // {path: '', redirectTo: 'login', pathMatch: 'full'},
    { path: 'login', component: LoginComponent },
    { path: 'logout', component: LogoutComponent }, 
];

@NgModule({
  imports: [RouterModule.forChild(routes)], // Use 'forChild' for feature modules
    exports: [RouterModule]
})
export class AuthentificationRoutingModule { }
