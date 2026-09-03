import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { catchError, map, of } from 'rxjs';
import { AuthService } from '../services/auth.service';

export const authGuard: CanActivateFn = () => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (!authService.getToken()) {
    return router.createUrlTree(['/users/login']);
  }

  return authService.getCurrentUser().pipe(
    map(() => true),
    catchError(() => {
      authService.clearToken();
      return of(router.createUrlTree(['/users/login']));
    }),
  );
};
