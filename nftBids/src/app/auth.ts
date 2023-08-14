import { Injectable } from '@angular/core';
import { Router } from '@angular/router';

@Injectable({
    providedIn: 'root',
})
export class AuthService {
    private userIsAuthenticated = false; 
    private userRole: string | null = null;

    constructor(private router: Router) {}

    setAuthenticated(status: boolean): void {
        this.userIsAuthenticated = status;
    }

    isAuthenticated(): boolean {
        return this.userIsAuthenticated;
    }

    setUserRole(role: string) {
        this.userRole = role;
        sessionStorage.setItem('userRole', role);
    } 

    getUserRole(): string | null {
        return this.userRole;
    } 
    authenticateUser(email: string, password: string, role: any): void {
        this.setAuthenticated(true);
        this.setUserRole(role);
    }
    

    logout(): void {
        this.userRole = null; // Clear the user role
        this.setAuthenticated(false);
        this.router.navigate(['/login']);
    }
    

}
