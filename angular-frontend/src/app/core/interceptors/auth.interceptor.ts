import { HttpInterceptorFn } from '@angular/common/http';
import { PLATFORM_ID, inject } from '@angular/core';
import { isPlatformBrowser } from '@angular/common';

const apiUrl = 'http://localhost:8000/api';
const tokenKey = 'omni_auth_token';

export const authInterceptor: HttpInterceptorFn = (request, next) => {
  if (!request.url.startsWith(apiUrl)) {
    return next(request);
  }

  const token = isPlatformBrowser(inject(PLATFORM_ID))
    ? localStorage.getItem(tokenKey)
    : null;
  if (!token) {
    return next(request);
  }

  return next(request.clone({
    setHeaders: {
      Authorization: `Bearer ${token}`,
      Accept: 'application/json',
    },
  }));
};
