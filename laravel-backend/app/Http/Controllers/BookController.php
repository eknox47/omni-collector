<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreBookRequest;
use App\Services\GoogleBooksService;
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
                $volumeInfo = $item['volumeInfo'];
                return [
                    'google_book_id' => $item['id'],
                    'title' => $volumeInfo['title'],
                    'description' => $volumeInfo['description'] ?? null,
                    'published_date' => $volumeInfo['publishedDate'] ?? null,
                    'page_count' => $volumeInfo['pageCount'] ?? null,
                    'publisher' => $volumeInfo['publisher'] ?? null,
                    'image' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                    'authors' => $volumeInfo['authors'] ?? null
                ];
            });
        } else {
            return [];
        }

        return $formattedBooks;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'google_book_id' => ['string']
        ]);

        $response = Http::get(
            'https://www.googleapis.com/books/v1/volumes/' . $validated['google_book_id'],
            [
                'key' => config('services.google_books.key'),
            ]
        );

        if($response->failed()) {
            return [
                "message" => "Server error"
            ];
        }

        $googleBooksService = new GoogleBooksService();
        $mappedBook = $googleBooksService->mapGoogleBooks($response->json());

        $book = Book::firstOrCreate(
            ['google_book_id' => $response['id']],
            $mappedBook
        );

        return $book;
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
