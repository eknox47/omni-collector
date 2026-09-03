import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { UserBook } from '../../models/userBook';

@Injectable({
	providedIn: 'root'
})

export class UserBookService {

	private readonly apiUrl = 'http://localhost:8000/api';

	constructor(private http: HttpClient) {}

	searchBooks(): Observable<UserBook[]> {
		return this.http.get<UserBook[]>(`${this.apiUrl}/user-books`, {
			// params: { },
		});
	}
}