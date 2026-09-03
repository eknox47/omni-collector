export interface Book {
  google_book_id: string;
  title: string;
  description: string | null;
  published_date: string | null;
  page_count: number | null;
  publisher: string | null;
  image: string | null;
  authors: string[] | null;
}