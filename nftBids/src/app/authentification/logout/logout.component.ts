import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TokenService } from 'src/app/services/token.service';

@Component({
  selector: 'app-logout',
  templateUrl: './logout.component.html',
})
export class LogoutComponent implements OnInit {
  constructor(private router: Router, private tokenService: TokenService) {}

  ngOnInit() {
    if (this.tokenService.isLogged()) {
      // User is logged in, perform logout
      this.tokenService.clearToken();
      console.log('Logged out!!');
    } else {
      // User is not logged
      console.log('User is not logged in.');
    }

    // Always navigate to the login page or any other desired page
    this.router.navigate(['/login']);
  }

  logout() {
    // Navigate to the logout route
    this.router.navigate(['/logout']);
  }
}
