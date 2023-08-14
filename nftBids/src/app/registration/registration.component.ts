import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { City } from '../city';
import { FormBuilder, FormGroup, MinLengthValidator, Validators } from '@angular/forms';
import { ApiService } from '../api.service';

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.css'],
})
export class RegistrationComponent implements OnInit {
  // Initialize an empty user object
  user: any = {
    firstName: '',
    lastName: '',
    email: '',
    gender: '',
    agreeTerms: false,
    plainPassword: '',
    roles: [],
    dateOfBirth: '',
    lives: {
      line1: '',
      city: {
        id: '', // This will hold the selected city's ID
        cityName: '',
      },
    },
  };

  cities!: City[];
  cityForm: FormGroup;

  rolesOptions = [
    { key: 'Seller', value: 'ROLE_SELLER' },
    { key: 'Buyer', value: 'ROLE_BUYER' },
    // Add more roles as needed
  ];

  // Inject the ApiService into the constructor,
  constructor(private http: HttpClient, private apiService: ApiService, private fb: FormBuilder) {
    this.cityForm = this.fb.group({
      cityName: '',
      postalCode: ''
    });

  }

  ngOnInit(): void {
    this.fetchCities();
  }

  fetchCities(): void {
    this.apiService.getCities().subscribe(
      (cities: City[]) => {
        this.cities = cities;
      },
      error => {
        console.error('Error fetching cities:', error);
      }
    );
  }

  onSubmit(): void {
    const cityData = this.cityForm.value;
    this.apiService.addCity(cityData).subscribe(
      (response: any) => {
        console.log('City added successfully:', response);
        this.fetchCities(); // Refresh the list of cities
        // Display success message to user
      },
      (error: any) => {
        console.error('Error adding city:', error);
        // Display error message to user
      }
    );
  }

  registerUser(): void {
    // Set the selected city's name in the user's data
    const selectedCity = this.cities.find((city) => city.id === this.user.lives.city.id);
    if (selectedCity) {
        this.user.lives.cityName = selectedCity.cityName;
        this.user.lives.city = selectedCity;
    }

    console.log('User data:', this.user);

    this.http.post('http://localhost:8000/api/register', this.user).subscribe(
        (response) => {
            console.log('Registration successful:', response);
            // You can add further logic here, such as redirecting to a success page.
        },

        (error: HttpErrorResponse) => {
          if (error.status >= 400 && error.status < 500) {
            console.error('Client Error:', error.status, error.statusText);
            // Handle client error, show user-friendly message, etc.
          } else {
            console.error('Server Error:', error.status, error.statusText);
            // Handle other types of errors (5xx, network errors, etc.)
          }
        }
    );
}
}
