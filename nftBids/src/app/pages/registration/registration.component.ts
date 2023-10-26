import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { RegistrationUser } from 'src/app/interfaces/UserRegistration';
import { UserService } from 'src/app/services/user.service';


@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.css']
})
export class RegistrationComponent {
  user: RegistrationUser = {
    email: '',
    roles: [], // You may need to adjust this based on your requirements
    plainPassword: '',
    firstName: '',
    gender: '',
    dateOfBirth: '',
    lives: '',
    lastName: '',
    nftFlows: []
  };

  constructor(private router: Router, private userService: UserService) {}

  onSubmit() {
    this.userService.registerUser(this.user).subscribe(
      (response) => {
        console.log('User registered successfully:', response);
  
        // Redirect to the home page
        this.router.navigate(['/home']); 
      },
      (error) => {
        //display an error message develop more
        console.error('Registration failed:', error);
      }
    );
  }
  
}
