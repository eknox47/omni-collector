import { Component, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { UserService } from '../../../core/services/user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-create',
  imports: [ReactiveFormsModule],
  templateUrl: './user-create.component.html',
  styleUrls: ['./user-create.component.css'],
})
export class UserCreateComponent {
  userForm: ReturnType<FormBuilder['group']>;
  errorMessage = signal('');
  private readonly validationMessages: Record<string, string> = {
    required: 'This field is required.',
    maxlength: 'Must be 30 characters or fewer.',
    email: 'Enter a valid email address.',
  };

  constructor(
    private formBuilder: FormBuilder,
    private userService: UserService,
    private router: Router,
  ) {
    this.userForm = this.formBuilder.group({
      first_name: ['', [Validators.required, Validators.maxLength(30)]],
      last_name: ['', [Validators.required, Validators.maxLength(30)]],
      username: ['', [Validators.required, Validators.maxLength(30)]],
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required],
    });
  }

  submit(): void {
    if (this.userForm.invalid) {
      this.userForm.markAllAsTouched();
      return;
    }

    this.errorMessage.set('');

    this.userService.createUser(this.userForm.value).subscribe({
      next: () => {
        void this.router.navigate(['/users/login']);
      },
      error: (error: any) => {
        this.errorMessage.set(error.error?.message ?? 'unable to create account'); 
      }
    });
  }

  isFieldInvalid(field: keyof typeof this.userForm.controls): boolean {
    const control = this.userForm.controls[field];
    return control.touched && control.invalid;
  }

  getFieldError(field: keyof typeof this.userForm.controls): string {
    const control = this.userForm.controls[field];

    if (!control.touched) {
      return '';
    }

    for (const errorName of Object.keys(this.validationMessages)) {
      if (control.hasError(errorName)) {
        if (errorName === 'required') {
          const label = String(field).replace('_', ' ');
          return `${label[0].toUpperCase()}${label.slice(1)} is required.`;
        }

        return this.validationMessages[errorName];
      }
    }

    return '';
  }

}