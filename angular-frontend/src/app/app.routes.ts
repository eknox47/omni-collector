import { Routes } from '@angular/router';
import { UserCreateComponent } from './features/users/user-create/user-create.component';
import { UserLoginComponent } from './features/users/user-login/user-login.component';
import { BookSearchComponent } from './features/books/book-search/book-search.component';
import { UserBookComponent } from './features/user-books/user-book/user-book.component';
import { authGuard } from './core/guards/auth.guard';

export const routes: Routes = [
    { 
			path: '',
			redirectTo: 'users/login',
			pathMatch: 'full'
		},
    { 
			path: 'users/create',
			component: UserCreateComponent,
		},
    { 
			path: 'users/login',
			component: UserLoginComponent,
		},
    { 
			path: 'books/search',
			component: BookSearchComponent,
			canActivate: [authGuard]
		},
		    { 
			path: 'users/books',
			component: UserBookComponent,
			canActivate: [authGuard]
		}
];
