<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreBookRequest;
use App\Services\PenguinRandomHouseService;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['required', 'string', 'max:255'],
        ]);

        if (config('services.penguin_random_house.fake')) {
            return $this->fakeSearchResults();
        }

        $response = Http::get(
            'https://api.penguinrandomhouse.com/resources/v2/title/domains/'
                . config('services.penguin_random_house.domain') . '/search',
            [
                'api_key' => config('services.penguin_random_house.key'),
                'q' => $validated['search'],
            ]
        );

        $titles = $response->json('data.titles');

        if (! $titles) {
            return [];
        }

        return collect($titles)
            ->filter(fn ($item) => ($item['docType'] ?? null) === 'title')
            ->map(function ($item) {
                $coverUrl = collect($item['links'] ?? [])->firstWhere('rel', 'icon')['href'] ?? null;

                return [
                    'isbn' => $item['isbn'] ?? null,
                    'title' => $item['title'],
                    'author' => $item['author'] ?? null,
                    'publisher' => $item['publisher']['description'] ?? null,
                    'published_date' => $item['onsale'] ?? null,
                    'page_count' => $item['pages'] ?? null,
                    'cover_url' => $coverUrl,
                ];
            })
            ->values();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => ['string']
        ]);

        //get the book info from PRH
        $response = Http::get(
            'isbn' . $validated['isbn'],
            [
                'key' => config('services.penguin_random_house.key'),
                'domain' => config('services.penguin_random_house.domain')
            ]
        );

        if($response->failed()) {
            return [
                "message" => "Server error"
            ];
        }

        $penguinRandomHouseService = new PenguinRandomHouseService();
        $mappedBook = $penguinRandomHouseService->mapPRHBooks($response->json());

        $book = Book::firstOrCreate($mappedBook);

        return $book;
    }

    public function show(string $id)
    { 
        return Book::where('id', $id);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    private function fakeSearchResults(): array
    {
        return [
            [
                'isbn' => '9781401235420',
                'title' => 'Batman: The Dark Knight Returns Omnibus',
                'author' => 'Frank Miller',
                'publisher' => 'DC Comics',
                'published_date' => '2016-10-04',
                'page_count' => 240,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401235420',
            ],
            [
                'isbn' => '9781401272289',
                'title' => 'Batman: Year One Omnibus',
                'author' => 'Frank Miller',
                'publisher' => 'DC Comics',
                'published_date' => '2017-03-14',
                'page_count' => 144,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401272289',
            ],
            [
                'isbn' => '9781779512315',
                'title' => 'Batman: Hush Omnibus',
                'author' => 'Jeph Loeb',
                'publisher' => 'DC Comics',
                'published_date' => '2020-11-10',
                'page_count' => 320,
                'cover_url' => 'https://images.randomhouse.com/cover/9781779512315',
            ],
            [
                'isbn' => '9781401284138',
                'title' => 'Batman: The Long Halloween Omnibus',
                'author' => 'Jeph Loeb',
                'publisher' => 'DC Comics',
                'published_date' => '2018-10-02',
                'page_count' => 384,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401284138',
            ],
            [
                'isbn' => '9781401270957',
                'title' => 'Batman: Knightfall Omnibus Vol. 1',
                'author' => 'Chuck Dixon',
                'publisher' => 'DC Comics',
                'published_date' => '2017-05-16',
                'page_count' => 608,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401270957',
            ],
            [
                'isbn' => '9781401290573',
                'title' => 'Batman: A Death in the Family Omnibus',
                'author' => 'Jim Starlin',
                'publisher' => 'DC Comics',
                'published_date' => '2019-08-27',
                'page_count' => 416,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401290573',
            ],
            [
                'isbn' => '9781401281175',
                'title' => 'Batman: No Man\'s Land Omnibus Vol. 1',
                'author' => 'Bob Gale',
                'publisher' => 'DC Comics',
                'published_date' => '2018-04-24',
                'page_count' => 608,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401281175',
            ],
            [
                'isbn' => '9781401265019',
                'title' => 'Batman by Scott Snyder & Greg Capullo Omnibus',
                'author' => 'Scott Snyder',
                'publisher' => 'DC Comics',
                'published_date' => '2016-11-08',
                'page_count' => 1040,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401265019',
            ],
            [
                'isbn' => '9781401248277',
                'title' => 'Batman: Court of Owls Omnibus',
                'author' => 'Scott Snyder',
                'publisher' => 'DC Comics',
                'published_date' => '2015-06-16',
                'page_count' => 368,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401248277',
            ],
            [
                'isbn' => '9781401295158',
                'title' => 'Batman: The Killing Joke Deluxe Omnibus',
                'author' => 'Alan Moore',
                'publisher' => 'DC Comics',
                'published_date' => '2019-03-19',
                'page_count' => 176,
                'cover_url' => 'https://images.randomhouse.com/cover/9781401295158',
            ],
        ];
    }
}
