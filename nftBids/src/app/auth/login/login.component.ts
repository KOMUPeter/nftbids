import { Component } from '@angular/core';
import { ICredential } from 'src/app/interfaces/credential';
import { AuthService } from 'src/app/services/auth.service';
import { TokenService } from 'src/app/services/token.service';
import { HttpHeaders } from '@angular/common/http';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  form: ICredential = {
    username: '',
    password: '',
  }

  constructor(private authService: AuthService, private tokenService: TokenService) {}

  ngOnInit() {}

  onSubmit() {
    console.log(this.form);

    // Create an instance of HttpHeaders
    // const headers = new HttpHeaders({
    //   'Content-Type': 'application/json',
    //   // Add the Authorization header if needed (e.g., for JWT authentication)
    //   // 'Authorization': 'Bearer ' + yourAccessToken,
    // });

    // Make the HTTP POST request without passing headers
this.authService.login(this.form).subscribe(
  (data) => {
    console.log(data.access_token);
    this.tokenService.saveToken(data.access_token); // Save the token
  },
  (error) => {
    console.log(error);
    // Handle error
  }
);
  }
}


