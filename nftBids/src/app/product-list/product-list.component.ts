import { Component, OnInit } from '@angular/core';
import { ApiService } from '../api.service'; // Import the ApiService
import { City } from '../city';
import { FormBuilder, FormGroup } from '@angular/forms'; 

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.css']
})
export class ProductListComponent implements OnInit {
  cities!: City[];
  cityForm: FormGroup;

  // Inject the ApiService into the constructor,
  constructor(private apiService: ApiService, private fb: FormBuilder) {
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

  // ngOnInit(): void {
  //   this.apiService.getCities().subscribe(
  //     (cities: City[]) => {
  //       this.cities = cities;
  //     },
  //     error => {
  //       console.error('Error fetching cities:', error);
  //     }
  //   );
  // }

  // city!: City;
  // this.apiService.getCityById(1).subscribe(data => this.city = data);

  }
  


