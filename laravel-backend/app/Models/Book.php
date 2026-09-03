<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $page_count
 * @property string $publisher
 * @property string $google_book_id
 * @property string $etag
 * @property string $isbn_10
 * @property string $isbn_13
 * @property int $average_rating
 * @property int $ratings_count
 * @property string $language
 * @property Carbon $published_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'title',
    'description',
    'page_count',
    'publisher',
    'google_book_id',
    'etag',
    'isbn_10',
    'isbn_13',
    'average_rating',
    'ratings_count',
    'language',
    'published_date'
])]
class Book extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
}
