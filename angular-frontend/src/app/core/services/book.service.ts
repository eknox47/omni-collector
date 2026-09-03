import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Book } from '../../models/book';

@Injectable({
	providedIn: 'root'
})

export class BookService {

	private readonly apiUrl = 'http://localhost:8000/api';

	constructor(private http: HttpClient) {}

	searchBooks(search: string): Observable<Book[]> {
		return this.http.get<Book[]>(`${this.apiUrl}/books`, {
			params: { search },
		});
	}
}