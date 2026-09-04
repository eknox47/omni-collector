export interface Book {
  isbn: string;
  title: string;
  author: string | null;
  publisher: string | null;
  published_date: string | null;
  page_count: number | null;
  cover_url: string | null;
}