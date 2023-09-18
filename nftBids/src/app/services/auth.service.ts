import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { ICredential } from '../interfaces/credential';
import { IToken } from '../interfaces/token';
import { Observable } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

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
    return this.http.post<IToken>(this.url, credentials, this.httpOptions);
  }
}

