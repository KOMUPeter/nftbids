import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class UserService {
    constructor(private http: HttpClient) {}

        getUserData() {
    // Replace 'your_user_data_api_endpoint' with the actual API endpoint
    return this.http.get('http://localhost:8000/api/users');
    }
}
