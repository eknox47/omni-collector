import { Routes } from '@angular/router';
import { UserCreateComponent } from './features/users/user-create/user-create.component';

export const routes: Routes = [
    { path: '', redirectTo: 'users/create', pathMatch: 'full'},
    { path: 'users/create', component: UserCreateComponent }
];
