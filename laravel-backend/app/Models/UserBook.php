<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $user_id
 * @property string $book_id
 * @property boolean $collected
 * @property boolean $read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['user_id', 'book_id', 'collected', 'read'])]
class UserBook extends Model
{
    public $table = "user_books";

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function book(): HasOne
    {
        return $this->hasOne(Book::class);
    }
}
