import { Injectable } from '@angular/core';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root',
})
export class TokenService {
  constructor(private router: Router) {}
  saveToken(token: string) {
    localStorage.setItem('token', token);
    this.router.navigate(['/']);
  }
  isLogged(): boolean {
    const token = localStorage.getItem('token'); // on stock le token
    console.log(token);
    return !!token; //!! permet de transform une variable en booleen donc si la cle existe pas il renvoi nul et null en boolen cest false
  }
  clearToken() {
    localStorage.removeItem('token');
    this.router.navigate(['/']);
  }
  getToken() {
    return localStorage.getItem('token');
  }
}
