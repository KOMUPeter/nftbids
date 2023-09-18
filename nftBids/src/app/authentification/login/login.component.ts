import { Component } from '@angular/core';
import { ICredential } from 'src/app/interfaces/credential';
import { AuthService } from 'src/app/services/auth.service';
import { TokenService } from 'src/app/services/token.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent {
  form: ICredential = {
    username: '',
    password: '',
  };

  constructor(
    private authService: AuthService,
    private tokenService: TokenService
  ) {}

  ngOnInit() {}

  onSubmit() {
    console.log(this.form);

    // Make the HTTP POST request without passing headers
    this.authService.login(this.form).subscribe(
      (data) => {
        console.log(data.access_token);
        this.tokenService.saveToken(data.access_token); // Save the token
      },
      (error) => {
        console.log(error);
        // Handle error
        this.handleErrorResponse(error);
      }
    );
  }

  //method to handle the error response
  private handleErrorResponse(error: any) {
    if (error.status === 401) {
      console.log('Unauthorized: Please check your credentials.');
    } else {
      console.error('An error occurred:', error);
    }
  }
}
