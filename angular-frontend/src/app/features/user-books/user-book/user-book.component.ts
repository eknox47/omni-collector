import { Component } from '@angular/core';
import { ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { UserBookService } from '../../../core/services/userBook.service';
import { UserBook } from '../../../models/userBook';

@Component({
  selector: 'app-user-book',
  imports: [ReactiveFormsModule],
  templateUrl: './user-book.component.html',
  styleUrls: ['./user-book.component.css'],
})
export class UserBookComponent {
  books: UserBook[] = [];
  errorMessage = '';
  isLoading = false;

  constructor(
    private bookService: UserBookService,
    //
  ) {
    //
  }
}
