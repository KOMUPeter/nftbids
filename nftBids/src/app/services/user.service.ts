import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})

export class UserService {
  private apiUrl = 'http://127.0.0.1:8000/api'; 

  constructor(private http: HttpClient) {}

  registerUser(user: any): Observable<any> {
    const registrationUrl = `${this.apiUrl}/users`;
    return this.http.post(registrationUrl, user);
  }
}
