import { Component } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { BookService } from '../../../core/services/book.service';
import { Book } from '../../../models/book';


@Component({
  selector: 'app-book-search',
  imports: [ReactiveFormsModule],
  templateUrl: './book-search.component.html',
  styleUrls: ['./book-search.component.css'],
})
export class BookSearchComponent {
  bookSearchForm: ReturnType<FormBuilder['group']>;
  books: Book[] = [];
  errorMessage = '';
  isLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private bookService: BookService,
  ) {
    this.bookSearchForm = this.formBuilder.group({
      search: ['', [Validators.required, Validators.maxLength(255)]],
    });
  }

  submit(): void {
    if (this.bookSearchForm.invalid) {
      this.bookSearchForm.markAllAsTouched();
      return;
    }

    this.errorMessage = '';
    this.isLoading = true;
    this.bookService.searchBooks(this.bookSearchForm.getRawValue().search ?? '').pipe(
      finalize(() => this.isLoading = false),
    ).subscribe({
      next: (books: any) => {
        this.books = books;
      },
      error: () => this.errorMessage = 'Unable to search for books.',
    });
  }
}