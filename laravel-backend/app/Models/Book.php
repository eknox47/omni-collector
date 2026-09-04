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
 * @property string 'height',
 * @property string 'width',
 * @property string 'thickness',
 * @property string 'small_thumbnail',
 * @property string 'thumbnail',
 * @property string 'small',
 * @property string 'medium',
 * @property string 'large',
 * @property string 'extra_large',
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'isbn',
    'work_id',
    'asin',
    'title',
    'subtitle',
    'author',
    'description',
    'publisher',
    'language',
    'published_date',
    'page_count',
    'format_code',
    'format_description',
    'price_amount',
    'price_currency',
    'length',
    'width',
    'depth',
    'gross_weight',
    'cover_url',
])]
class Book extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    public function authors(): HasMany
    {
        return $this->hasMany(Authors::class);
    }
}
