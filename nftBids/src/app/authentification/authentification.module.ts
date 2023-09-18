import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';


import { AuthentificationRoutingModule } from './authentification-routing.module';
import { LoginComponent } from './login/login.component';
import { LogoutComponent } from './logout/logout.component';
import { FormsModule } from "@angular/forms";

@NgModule({
    declarations: [
        LoginComponent, 
        LogoutComponent
    ],

    imports: [
    CommonModule,
    AuthentificationRoutingModule,
    FormsModule,
    ]
})
export class AuthentificationModule { }
