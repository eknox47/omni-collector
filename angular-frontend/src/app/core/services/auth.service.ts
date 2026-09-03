
	
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map, tap } from 'rxjs';
import { User } from '../../models/user';

export interface Credentials {
	email: string;
	password: string;
}

interface AuthResponse {
	user: User;
	token: string;
}

@Injectable({
	providedIn: 'root'
})

export class AuthService {
	private readonly apiUrl = 'http://localhost:8000/api';
	private readonly tokenKey = 'omni_auth_token';

    constructor(private http: HttpClient) {}

	loginUser(credentials: Credentials): Observable<User> {
		return this.http.post<AuthResponse>(
			`${this.apiUrl}/login`,
			credentials
		).pipe(tap(({ token }) => this.storeToken(token)),
			tap(({ user }) => this.currentUser = user),
			map(({ user }) => user));
	}

	private currentUser: User | null = null;

	getToken(): string | null {
		return typeof localStorage === 'undefined' ? null : localStorage.getItem(this.tokenKey);
	}

	logout(): Observable<void> {
		return this.http.post<void>(`${this.apiUrl}/logout`, {}).pipe(
			tap(() => this.clearToken()),
		);
	}

	clearToken(): void {
		if (typeof localStorage !== 'undefined') {
			localStorage.removeItem(this.tokenKey);
		}
		this.currentUser = null;
	}

	private storeToken(token: string): void {
		if (typeof localStorage !== 'undefined') {
			localStorage.setItem(this.tokenKey, token);
		}
	}

	getCurrentUser(): Observable<User> {
		return this.http.get<User>(`${this.apiUrl}/user`);
	}

}