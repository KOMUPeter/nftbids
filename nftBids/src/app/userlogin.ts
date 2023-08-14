import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, tap } from 'rxjs';
import { Router } from '@angular/router';
import { AuthService } from './auth';

@Injectable({
  providedIn: 'root'
})
export class UserLoginService {
  private baseUrl = 'http://localhost:8000/api/users';

  constructor(
    private http: HttpClient,
    private router: Router,
    private authService: AuthService
  ) {}

  login(email: string, password: string) {
    const loginData = { email, password };
    return this.http.post(`${this.baseUrl}/login`, loginData).pipe(
      tap((response: any) => {
        const userRole = response.user.role;
        this.authService.authenticateUser(email, password, userRole);
        localStorage.setItem('user', JSON.stringify(response.user));
        localStorage.setItem('token', response.token);
        this.redirectUser(userRole);
      })
    );
  }

  private redirectUser(role: string): void {
    if (role === 'ROLE_ADMIN') {
      this.router.navigate(['/admin']);
    } else if (role === 'ROLE_BUYER') {
      this.router.navigate(['/buyer']);
    } else if (role === 'ROLE_SELLER') {
      this.router.navigate(['/seller']);
    } else {
      this.router.navigate(['/home']);
    }
  }

  // Method to fetch user details by ID
  getUserById(userId: number): Observable<any> {
    const url = `${this.baseUrl}/api/user/${userId}`;
    return this.http.get(url);
  }
}
