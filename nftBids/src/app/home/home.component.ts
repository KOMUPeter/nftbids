
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Nft } from '../images-interface';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  nfts: Nft[] = [];

  constructor(private http: HttpClient) {}

  urlNfts = 'http://127.0.0.1:8000/api/nfts';

  ngOnInit(): void {
    this.http.get<any>(this.urlNfts).subscribe((response) => {
      this.nfts = response['hydra:member'];
      console.log(this.nfts);
    });
  }

}

