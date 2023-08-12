import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
    selector: 'app-registration',
    templateUrl: './registration.component.html',
})
export class RegistrationComponent {
    user: any = {}; // Object to store form data

    constructor(private http: HttpClient) {}

    registerUser() {
        this.http.post('/api/register', this.user).subscribe(response => {
            console.log('Registration successful:', response);
            // You can add further logic here, such as redirecting to a success page.
        }, error => {
            console.error('Registration failed:', error);
        });
    }
}
