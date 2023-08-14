import { Component } from '@angular/core';
import { UserLoginService } from '../userlogin';
import { AuthService } from '../auth';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  email!: string;
  password!: string;
  user: any;
  errorMessage!: string;
  // ... Other properties and methods

  constructor( private userLoginService: UserLoginService,
    private authService: AuthService, // Add this line
    private router: Router) {}

  onSubmit(): void {
    this.userLoginService.login(this.email, this.password).subscribe(
      (response: { user: any; }) => {
        this.user = response.user;
        this.errorMessage = '';
  
        this.userLoginService.getUserById(this.user.id).subscribe(
          (userData) => {
            this.user = userData;
            const userRole = userData.role; 
                this.authService.authenticateUser(this.email, this.password, userRole);

                if (userRole === 'ROLE_ADMIN') {
                    this.router.navigate(['/admin']);
                } else if (userRole === 'ROLE_BUYER') {
                    this.router.navigate(['/buyer']);
                } else if (userRole === 'ROLE_SELLER') {
                    this.router.navigate(['/seller']);
                } else {
                    this.router.navigate(['/home']);
                }
            },
          
          (errorResponse) => {
            console.log('Error fetching user details:', errorResponse);
          }
        );
      },
      (errorResponse) => {
        this.errorMessage = 'Login failed. Please fill in valid information.';
        this.user = null;

        console.error('Login error:', errorResponse);
      }
    );
  }
}
