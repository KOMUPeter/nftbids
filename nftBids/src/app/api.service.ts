import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, catchError, throwError } from 'rxjs'; // to Import Observable
import { Product } from './product.model';
import { City } from './city';
import { map } from 'rxjs/operators';

@Injectable({
    providedIn: 'root',
})
export class ApiService {
    addCity(cityData: any): Observable<any> {
    return this.http.post(this.apiUrl, cityData);
  }
    private apiUrl = 'http://localhost:8000/api/cities'; 

    constructor(private http: HttpClient) {}
    

    getCities(): Observable<City[]> {
        return this.http.get<{ 'hydra:member': City[] }>(this.apiUrl)
            .pipe(map(response => response['hydra:member']));
    }

    // private apiUrl = '/api/cities'; 
    // getCityById(id: number): Observable<City>{
    //     return this.http.get<City>(`http://localhost:8000/api/cities/${id}`);
    // }
}
