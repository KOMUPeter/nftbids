import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { NotFoundComponent } from './not-found/not-found.component';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './authentification/login/login.component';
import { RegistrationComponent } from './pages/registration/registration.component';


const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'login', component: LoginComponent }, // add login page here for redirection after logout
  { path: 'authentication', loadChildren: () => import('./authentification/authentification.module').then(m => m.AuthentificationModule) },
  // Other routes
  { path: 'pages/registration', component: RegistrationComponent },
  { path: '**', component: NotFoundComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
