import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { ICredential } from '../interfaces/credential';
import { IToken } from '../interfaces/token';
import { Observable } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private isLoggedInValue = false; 

  get isLoggedIn(): boolean {
    return this.isLoggedInValue;
  }

  setLoggedIn(value: boolean) {
    this.isLoggedInValue = value;
  }

  url = 'http://127.0.0.1:8000/api/login';

  // Define headers here
  private httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
      'Origin': 'http://localhost:4200'
    })
  };

  constructor(private http: HttpClient) { }

  login(credentials: ICredential): Observable<IToken> {
    // Assuming a successful login sets isLoggedIn to true
    return this.http.post<IToken>(this.url, credentials, this.httpOptions);
  }

  saveToken(token: string) {
    // Save the token to local storage or a secure storage mechanism
    localStorage.setItem('access_token', token);
    this.setLoggedIn(true);
  }

  // Add a method to check if the user is already logged in based on the presence of a token
  checkToken(): boolean {
    return !!localStorage.getItem('access_token');
  }

  // Add a method to log out
  logout() {
    // Clear the token from storage and set logged in to false
    localStorage.removeItem('access_token');
    this.setLoggedIn(false);
  }
}
