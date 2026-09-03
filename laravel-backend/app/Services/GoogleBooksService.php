<?php

namespace App\Services;

class GoogleBooksService
{
    public function mapGoogleBooks($googleBook)
    {

        $volumeInfo = $googleBook['volumeInfo'];

        $isbn10 = null;
        $isbn13 = null;

        $industryIdentifiers = collect($volumeInfo['industryIdentifiers'] ?? null);
        $isbn10Object = $industryIdentifiers->firstWhere('type', 'ISBN_10');
        $isbn13Object = $industryIdentifiers->firstWhere('type', 'ISBN_13');

        if($isbn10Object) {
            $isbn10 = $isbn10Object['identifier'];
        }

        if($isbn13Object) {
            $isbn13 = $isbn13Object['identifier'];
        }

        $book = [
            'google_book_id' => $googleBook['id'],
            'title' => $volumeInfo['title'],
            'description' => $volumeInfo['description'] ?? null,
            'published_date' => $volumeInfo['publishedDate'] ?? null,
            'page_count' => $volumeInfo['pageCount'] ?? null,
            'publisher' => $volumeInfo['publisher'] ?? null,
            'etag' => $googleBook['etag'] ?? null,
            'image' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
            'authors' => $volumeInfo['authors'] ?? null,
            'average_rating' => $volumeInfo['averageRating'] ?? null,
            'ratings_count' => $volumeInfo['ratingsCount'] ?? null,
            'language' => $volumeInfo['language'] ?? null,
            'isbn_10' => $isbn10,
            'isbn_13' => $isbn13,
        ];

        return $book;
    }
}