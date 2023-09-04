import { Component } from '@angular/core';

@Component({
  selector: 'app-logout',
  templateUrl: './logout.component.html',
  styleUrls: ['./logout.component.css']
})
export class LogoutComponent {

}
// form: ICredential= {
//   username:'',
//   password:'',
// }

// constructor(private authService: AuthService,
//           private  tokenService: TokenService){}
// ngOnInit(){

// }
// onSubmit(){
//   console.log(this.form)
//   this.authService.login(this.form).subscribe(
//     data =>{
//     console.log(data.access_token)
//       this.tokenService.saveToken(data.access_token)//permet d'acceder au token
//   } ,
//   err => console.log(err)

//   )
// }
