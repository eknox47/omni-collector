import { Book } from './book';

export interface UserBook extends Book {
	collected: boolean;
	read: boolean;
}