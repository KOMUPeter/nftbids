import { Component } from '@angular/core';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent {

   // Use the getter from AuthService to check authentication status
  get isLoggedIn(): boolean {
    return this.authService.checkToken();
  }

  constructor(private authService: AuthService) {}
}

