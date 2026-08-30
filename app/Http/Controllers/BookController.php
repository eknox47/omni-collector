<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['string', 'max:255']
        ]);

        $response = Http::get(
            'https://www.googleapis.com/books/v1/volumes',
            [
                'q' => $validated['search'],
                'key' => config('services.google_books.key'),
            ]
        );

        $json = $response->json();

        if($json['items']){
            $collection = collect($json['items']);
            $formattedBooks = $collection->map(function ($item, int $key) {
                return [
                    'title' => $item['volumeInfo']['title'],
                    'description' => $item['volumeInfo']['description'] ?? null,
                    'published_date' => $item['volumeInfo']['publishedDate'] ?? null,
                    'page_count' => $item['volumeInfo']['pageCount'] ?? null,
                    'publisher' => $item['volumeInfo']['publisher'] ?? null,
                    'google_book_id' => $item['id'],
                    'etag' => $item['etag'] ?? null,
                    'image' => $item['volumeInfo']['imageLinks']['thumbnail'] ?? null,
                    'authors' => $item['volumeInfo']['authors'] ?? null
                ];
            });
        } else {
            return [];
        }

        return $formattedBooks;
    }

    public function store(StoreBookRequest $request)
    {
        $bookValidation = [
            'title' => ['string', 'max:255'],
            'google_book_id' => ['required', 'string'],
            'description' => ['string', 'max:255'],
            'page_count' => ['int'],
            'publisher' => ['string', 'max:50'],
            'etag' => ['string'],
            'isbn_10' => ['string', 'max:10'],
            'isbn_13' => ['string', 'max:13'],
            'average_rating' ['int'],
            'ratings_count' => ['int'],
            'language' => ['string'],
            'published_date' => ['date'],
        ];

        $book = Book::firstOrCreate(
            ['google_book_id' => $validated['google_book_id']],
            $validated
        );

        return $book->toJson();
    }

    public function show(string $id)
    { 
        return [
            'book' => 'Dc Omnibus vol 2'
        ];
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
