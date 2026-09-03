import { Component } from '@angular/core';
import { ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { UserBookService } from '../../../core/services/userBook.service';

@Component({
  selector: 'app-view-user-book',
  imports: [ReactiveFormsModule],
  templateUrl: './view-user-book.component.html',
  styleUrls: ['./view-user-book.component.css'],
})