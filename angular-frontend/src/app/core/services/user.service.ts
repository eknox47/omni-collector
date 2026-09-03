import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

interface User {
	id: number,
	first_name: string,
	last_name: string,
	username: string,
	email: string,
	password: string
};

@Injectable({
	providedIn: 'root'
})

export class UserService {

	private apiUrl = "http://localhost:8000/api";

	constructor(private http: HttpClient) {}

	createUser(user: any): Observable<User> {
		return this.http.post<User>(
			`${this.apiUrl}/user`,
			user
		)
	};
}